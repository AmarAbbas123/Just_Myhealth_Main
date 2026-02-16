<?php

namespace App\Traits;

trait SanitizesInput
{
    protected static function bootSanitizesInput()
    {
        static::saving(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {

                // Skip nulls
                if (is_null($value)) {
                    continue;
                }

                // Normal string attributes (not JSON columns)
                if (is_string($value) && !$model->isJsonColumn($key)) {
                    $model->setAttribute($key, self::cleanValue($value));
                    continue;
                }

                // JSON column cleaning
                if ($model->isJsonColumn($key)) {
                    $decoded = null;

                    if (is_string($value) && self::isJson($value)) {
                        $decoded = json_decode($value, true);
                    } elseif (is_array($value)) {
                        $decoded = $value; // Already cast by Laravel
                    } else {
                        continue;
                    }

                    // Clean all strings inside
                    array_walk_recursive($decoded, function (&$item) {
                        if (is_string($item)) {
                            $item = self::cleanValue($item);
                        }
                    });

                    // ✅ If Laravel is already casting, just set the array
                    $model->setAttribute($key, $decoded);
                }
            }
        });
    }

    protected static function cleanValue($string)
    {
        return strip_tags($string, '<p><a><b><i><u><strong><em><br>');
    }

    protected static function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    protected function isJsonColumn($key)
    {
        return in_array($key, ['ProfileData']);
    }
}

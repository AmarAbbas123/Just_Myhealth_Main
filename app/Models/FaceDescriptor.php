<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaceDescriptor extends Model
{
    protected $fillable = [
        'user_id',
        'Descriptor',
        'SampleCount',
        'RegisteredAt',
    ];

    protected $casts = [
        'Descriptor' => 'array',
        'RegisteredAt' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Euclidean distance between this descriptor and a candidate descriptor.
     * face-api.js convention: distance < ~0.6 is generally the same person
     * (this is the same threshold face-api.js's own FaceMatcher uses by default).
     */
    public function distanceTo(array $candidate): float
    {
        $stored = $this->Descriptor;

        if (count($stored) !== count($candidate)) {
            return INF;
        }

        $sumSquares = 0.0;
        foreach ($stored as $i => $value) {
            $diff = $value - $candidate[$i];
            $sumSquares += $diff * $diff;
        }

        return sqrt($sumSquares);
    }
}

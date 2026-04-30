<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
class ProfileUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true; // ✅ Make sure this is TRUE
    }

    public function rules(): array
    {
        $rules = [
            'UserName' => 'required|string|max:255',
            // Add more static fields here if needed
        ];

        $userType = $this->input('UserType'); // Or use $this->user()->UserType if not in input
        $allFields = config("user_fields.$userType", []);
        $allOptions = array_merge(
            config('user_options'),
            config('business_options'),
            config('medical_options'),
            config('professional_options')
        );

        foreach ($allFields as $field => $label) {
            if (isset($allOptions[$field])) {
                // This is a multi-select field
                $rules["ProfileData.$field"] = 'nullable|array';
                $rules["ProfileData.$field.*"] = 'string|max:255';
            } else {
                // Single field
                $rules["ProfileData.$field"] = 'nullable|string|max:255';
            }
        }

        return $rules;
    }
       
    
}

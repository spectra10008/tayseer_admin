<?php

namespace App\Http\Requests\MfiProviders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $auth_id = Auth::guard('mfis_providers')->id();
        return [
            "name" => "required|string|max:255",
            "email" => 'required|email|max:255|unique:mfi_provider_users,email,' . $auth_id,
            "phone" => "required|numeric|digits_between:9,12",
            "is_active" => "required|numeric",
            'profile_pic' => 'nullable|mimes:jpg,bmp,png|max:2048',
        ];
    }
}

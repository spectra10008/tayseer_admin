<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMfiProviderUserRequest extends FormRequest
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
        return [
            'name' => 'required|max:255|string',
            'email' => 'required|max:255|email|unique:mfi_provider_users,email,'.request()->id,
            'password' => 'nullable|min:8',
            'is_active' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:9,12|unique:mfi_provider_users,phone,'.request()->id,
            'profile_pic' => 'nullable|mimes:jpg,bmp,png|max:2048',
        ];
    }
}

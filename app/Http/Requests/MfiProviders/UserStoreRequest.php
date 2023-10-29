<?php

namespace App\Http\Requests\MfiProviders;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'email' => 'required|max:255|email|unique:mfi_provider_users',
            'password' => 'required|min:8',
            'is_active' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:9,12|unique:mfi_provider_users',
            'profile_pic' => 'required|mimes:jpg,bmp,png|max:2048',
        ];
    }
}

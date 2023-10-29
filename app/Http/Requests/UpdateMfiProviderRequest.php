<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMfiProviderRequest extends FormRequest
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
            "name_ar" => 'required|string|max:255',
            "name_en" => 'required|string|max:255',
            "business_email" => 'required|email|max:255|unique:mfi_providers,business_email,'.request()->id,
            "phone" => 'required|numeric|digits_between:9,12',
            "description_ar" => 'required|string',
            "description_en" => 'required|string',
            "address" => 'required|string',
            "is_active" => 'required|numeric|digits:1',
            "profile_pic" => 'nullable|mimes:png,jpg,jpeg,svg|max:2048'
        ];
    }
}

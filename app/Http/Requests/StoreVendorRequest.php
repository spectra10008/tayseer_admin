<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name"=>"required|string|max:255",
            "email"=>"string|max:255|email",
            "phone"=>"required|numeric|digits_between:9,12",
            "address"=>"required|string|max:255",
            "sale_info"=>"string",
            "latitude"=>"required|string|max:255",
            "longitude"=>"required|string|max:255",
            "profile_pic"=>'nullable|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}

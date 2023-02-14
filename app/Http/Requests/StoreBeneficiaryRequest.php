<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
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
            'name' => 'required|max:255|string',
            'gender' => 'required|max:255|string',
            'email' => 'required|max:255|email',
            'phone' => 'required|numeric|digits_between:9,12',
            'age' => 'required|numeric',
            'id_number' => 'required|numeric',
            'social_situation_id' => 'required|numeric|exists:social_situations,id',
            'children_no' => 'required|numeric',
            'address' => 'required|string',
            'is_bank_account' => 'required|numeric',
            'bank_id' => 'nullable|numeric|exists:banks,id',
            'branch_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|numeric',
            'image' => 'required|mimes:jpg,bmp,png|max:2048',
            'id_image' => 'required|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    }
}

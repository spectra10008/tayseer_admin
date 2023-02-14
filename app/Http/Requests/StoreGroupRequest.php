<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'group_name' => 'required|max:255|string',
            'group_address' => 'required|max:255|string',
            'group_contact' => 'required|numeric|digits_between:9,12',
            'is_registered' => 'required|numeric',
            'group_leader_id' => 'required|numeric|exists:beneficiaries,id',
            'register_type_id' => 'required|numeric|exists:group_register_types,id',
            'is_bank_account' => 'required|numeric',
            'bank_id' => 'nullable|numeric|exists:banks,id',
            'branch_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|numeric',
            'foundation_certificate' => 'nullable|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    }
}

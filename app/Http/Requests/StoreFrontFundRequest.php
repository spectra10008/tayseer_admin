<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrontFundRequest extends FormRequest
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
            'gender' => 'required|max:255|string',
            'email' => 'nullable|max:255|email',
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
            'project_name' => 'required|max:255|string',
            'fund_type_id' => 'required|numeric|exists:fund_types,id',
            'project_sector_id' => 'required|numeric|exists:sectors,id',
            'project_fund_need' => 'required|numeric',
            'notes' => 'nullable|string',
            'project_desc' => 'required|string',
            'feasibility_study_file' => 'nullable|mimes:jpg,bmp,png,pdf|max:2048',
            'personal_image' => 'nullable|mimes:jpg,bmp,png,pdf|max:2048',
            'id_file' => 'nullable|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    }
}

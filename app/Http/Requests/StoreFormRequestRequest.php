<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequestRequest extends FormRequest
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
            'beneficiary_id' => 'required|numeric|exists:beneficiaries,id',
            'mfi_provider_id' => 'nullable|numeric|exists:mfi_providers,id',
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

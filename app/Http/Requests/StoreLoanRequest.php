<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            "request_id"=>"required|numeric|exists:form_requests,id",
            "product_id"=>"string|numeric|exists:loan_products,id",
            'mfi_provider_id' => 'nullable|numeric|exists:mfi_providers,id',
            "loan_amount"=>"required|numeric",
            "released_date"=>"required|string|max:255",
            "loan_duration"=>"required|string|max:255",
            "description"=>"required|string",
            "loan_interest"=>"required|numeric",
            "loan_manager"=>"required|exists:users,id",
            "loan_file"=>'required|mimes:pdf|max:2048',
        ];
    }
}

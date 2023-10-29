<?php

namespace App\Http\Requests\MfiProviders;

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
            "loan_amount"=>"required|numeric",
            "released_date"=>"required|string|max:255",
            "loan_duration"=>"required|string|max:255",
            "description"=>"required|string",
            "loan_interest"=>"required|numeric",
            "loan_file"=>'required|mimes:pdf|max:2048',
            "loan_manager"=>"string|numeric|exists:mfi_provider_users,id",
        ];
    }
}

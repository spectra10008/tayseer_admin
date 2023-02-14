<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstallmentRequest extends FormRequest
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
            'request_id' => 'required|numeric|exists:form_requests,id',
            'beneficiary_id' => 'required|numeric|exists:beneficiaries,id',
            'deserved_amount' => 'required|numeric',
            'date_payment_installment' => 'required|after_or_equal:today',
        ];
    }
}

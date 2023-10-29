<?php

namespace App\Http\Requests\MfiProviders;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstallmentSystemRequest extends FormRequest
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
            'loan_id' => 'required|numeric|exists:loans,id',
            'deserved_amount' => 'required|numeric',
            'installments_no' =>' required|numeric',
            'date_payment_installment' => 'required|after_or_equal:today'
        ];
    }
}

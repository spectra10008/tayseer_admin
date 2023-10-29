<?php

namespace App\Http\Requests\MfiProviders;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstallmentRequest extends FormRequest
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
            'deserved_amount' => 'required|numeric',
            'date_payment_installment' => 'required|after_or_equal:today',
            'status_id' => 'required|numeric|exists:installment_statuses,id',
            'receipt_file' => 'nullable|mimes:jpeg,png,pdf|max:2048',
        ];
    }
}

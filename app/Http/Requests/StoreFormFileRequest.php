<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormFileRequest extends FormRequest
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
            "file_name" => "required|string|max:255",
            'file' => 'required|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    }
}

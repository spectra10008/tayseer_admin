<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'project_name' => 'required|max:255|string',
            'status' => 'required|max:255|string',
            'address' => 'required|max:255|string',
            'sector_id' => 'required|numeric|exists:sectors,id',
            'start_date' => 'nullable|string|max:255',
            'desc' => 'required|string',
            'need' => 'required|string',
            'notes' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'fund_amount_need_sdg' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    }
}

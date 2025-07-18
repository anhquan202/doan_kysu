<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStatus extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.integer' => 'Trạng thái phải là số nguyên.',
        ];
    }
}

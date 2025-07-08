<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone_number' => 'nullable|regex:/^0[0-9]{9}$/',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'address' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female,other',
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'Vui lòng nhập họ.',
            'first_name.string' => 'Họ phải là chuỗi ký tự.',
            'first_name.max' => 'Họ không được vượt quá 50 ký tự.',
            'last_name.required' => 'Vui lòng nhập tên.',
            'last_name.string' => 'Tên phải là chuỗi ký tự.',
            'last_name.max' => 'Tên không được vượt quá 50 ký tự.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'avatar.required' => 'Vui lòng chọn ảnh đại diện.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'gender.in' => 'Giới tính không hợp lệ.',
        ];
    }
}

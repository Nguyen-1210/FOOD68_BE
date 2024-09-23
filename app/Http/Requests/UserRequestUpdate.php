<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class UserRequestUpdate extends BaseRequest
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
        $userId = $this->route()->parameters['id'];
        return [
            'name' => 'nullable|string|min:2|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|max:255',
            'confirm_password' => 'nullable|string|min:6|max:255|same:password',
            'phone' => 'nullable|string|min:2|max:255',
        ];
      }

        public function messages(): array
        {
            return [
                'required'        => 'Trường :attribute là bắt buộc',
                'in'              => 'Giá trị của :attribute không hợp lệ',
                'email'           => ':attribute không hợp lệ',
                'unique'          => ':attribute đã tồn tại',
                'min'             => ':attribute quá ngắn',
                'max'             => ':attribute quá dài',
                'same'            => ':attribute không khớp',
            ];
        }
    
        public function attributes(): array
        {
            return [
                'name' => 'Họ và tên',
                'email'     => 'Email',
                'password'  => 'Mật khẩu',
                'confirm_password' => 'Mật khẩu xác nhận',
                'phone'     => 'Số điện thoại',
            ];
        }
}
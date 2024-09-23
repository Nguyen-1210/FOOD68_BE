<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class TableRequestOrder extends BaseRequest
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
    public function rules()
    : array {
        return [
            'table_id' => 'required|integer',
            'order_date' => 'required|date',
            'user_name' => 'required|string',
            'phone' => 'required|min:10|max:10',
        ];
    }

    public function messages()
    : array {
        return [
            'order_date.required' => 'Thời gian đặt bàn không được để trống',
            'user_name.required' => 'Người dùng không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại không được quá 11 số',
            'phone.min' => 'Số điện thoại không được dưới 10 số',
        ];
    }
}
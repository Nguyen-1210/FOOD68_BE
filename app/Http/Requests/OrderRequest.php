<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
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
            'table_order_id' => 'required|integer|exists:table_order,id',
        ];
    }

    public function messages(): array
    {
        return [
            'table_order_id.required' => 'Table order id is required!',
            'table_order_id.integer' => 'Table order id must be an integer!',
            'table_order_id.exists' => 'Table order id does not exist!',
        ];
    }
}
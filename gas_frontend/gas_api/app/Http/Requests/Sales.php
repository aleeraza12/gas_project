<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Sales extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $array['gas_quantity'] = 'required|string';
        $array['total_amount'] = 'required';
        $array['price'] = 'required';
        $array['customer_id'] = 'required';
        $array['customer_phone_number'] = 'required';
        $array['customer_type'] = 'required';
        $array['discount_code'] = 'sometimes';
        $array['company_id'] = 'required';
        $array['payment_mode'] = 'sometimes|array';
        $array['user_id'] = 'required';
        return $array;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }
}

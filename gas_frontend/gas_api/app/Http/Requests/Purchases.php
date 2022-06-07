<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Purchases extends FormRequest
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
        $array['date'] = 'required|date';
        $array['receipt_number'] = 'required';
        $array['company_name'] = 'required';
        $array['company_phone_number'] = 'required';
        $array['driver_name'] = 'required';
        $array['gas_quantity'] = 'required';
        $array['amount'] = 'required';
        $array['unit_price'] = 'required';
        $array['recepient_name'] = 'required';
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

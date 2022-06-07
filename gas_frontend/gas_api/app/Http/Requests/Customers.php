<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Customers extends FormRequest
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
        $array['name'] = 'required|string';
        $array['email'] = 'required|email';
        $array['phone_number'] = 'required';
        $array['customer_type'] = 'required';
        $array['city'] = 'required';
        $array['state'] = 'required';
        $array['address'] = 'required';
        return $array;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }
}

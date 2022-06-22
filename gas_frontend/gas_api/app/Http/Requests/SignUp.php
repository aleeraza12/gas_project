<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SignUp extends FormRequest
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
        $array['owner_name'] = 'required|string';
        $array['company_email'] = 'required|unique:companies,company_email,' . $this->company_id;
        $array['company_name'] = 'required';
        $array['password'] = 'required|min:3|max:20';
        $array['company_phone_number'] = 'required|min:8|max:13';
        $array['city'] = 'required';
        $array['state'] = 'required';
        //$array['gas_plant_type'] = 'required';
        $array['permissions'] = 'sometimes|array';
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

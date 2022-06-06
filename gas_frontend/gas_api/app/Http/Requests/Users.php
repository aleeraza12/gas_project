<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Users extends FormRequest
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
        $array['created_by'] = 'required';
        $array['designation'] = 'required';
        $array['password'] = 'required';
        $array['permissions'] = 'required';
        $array['user_type'] = 'required';
        $array['status'] = 'required';
        $array['company_id'] = 'required';
        return $array;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }
}

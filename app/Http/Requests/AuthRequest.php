<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AuthRequest extends Request
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
        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
    }
    public function messages() {
        return [
            'validation.email' =>'Please enter a valid email address',
            'email' => "We can't find a user with that e-mail address",
            'email.required' => 'Your email is required',
            'email.valid' => 'Please enter a valid email address'

        ];

    }
}

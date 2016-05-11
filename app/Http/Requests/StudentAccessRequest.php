<?php

namespace App\Http\Requests;

use App\Feedback;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;

/**
 * The request which a student makes when they attempt to log in
 * with the access key provided.
 *
 * The validation checks include determining whether the access key exists in the feedback table.
 * If not, this will reject the request and redirect back from origin with a message that key was invalid.
 *
 * @package App\Http\Requests
 */
class StudentAccessRequest extends Request
{
    const ACCESS_KEY_MAX_LENGTH = 225;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'accessKey' => 'required|exists:feedback,access_key|alpha_num|max:' . self::ACCESS_KEY_MAX_LENGTH
        ];
    }

    public function messages()
    {
        return [
          'accessKey' => 'The access key you provided was invalid',
            'accessKey.required' => 'Please enter your access key',
            'accessKey.exists' => 'The access key you provided was invalid',
            'accessKey.alpha_num' => 'The access key you provided was invalid',
            'accessKey.max' => 'The access key you provided was invalid'
        ];
    }
}

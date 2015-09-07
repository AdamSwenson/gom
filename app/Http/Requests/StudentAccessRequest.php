<?php

namespace App\Http\Requests;

use App\Feedback;
use App\Http\Requests\Request;

class StudentAccessRequest extends Request
{
    const ACCESS_KEY_MAX_LENGTH = 225;

    /**
     * Determine if the user is authorized to make this request.
     * Does this by checking whether the access key exists in the feedback table.
     * If not, rejects the request.
     * @return bool
     */
    public function authorize()
    {
        $ak = $this->route('accessKey');
        return Feedback::where('access_key', $ak)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'accessKey' => 'required|alpha_num|max:' . self::ACCESS_KEY_MAX_LENGTH
        ];
    }

    public function messages()
    {
        return [
          'accessKey' => 'The access key you provided was invalid'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Question;

/**
 * Class QuestionRequest
 *
 * Holds the incoming form data and handles validation for a question creation request
 *
 * @package App\Http\Requests
 */
class QuestionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO Set up authorization
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
            'questionName' => 'min:1|max:225',
            'questionText' => 'max:5000'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Question;

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
//            'questionName' => ['required', min(Question::MIN_NAME_LENGTH), max(Question::MAX_NAME_LENGTH)],
//            'questionText' => [min(Question::MIN_TEXT_LENGTH), max(Question::MAX_TEXT_LENGTH)],
//            'questionDesc' => [min(Question::MIN_TEXT_LENGTH), max(Question::MAX_TEXT_LENGTH)],
//            'order' => 'integer',
//            'examId' => 'integer',
//            'classId' => 'integer'
        ];
    }
}

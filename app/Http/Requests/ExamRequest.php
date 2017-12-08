<?php

namespace App\Http\Requests;

use App\Exam;

/**
 * Class ExamRequest
 *
 * Handles requests for doing stuff with exams
 *
 * @package App\Http\Requests
 */
class ExamRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $this->user()->id;
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
//            'description'
        //'type'
//            'family'
            'year' => 'date_format:Y',
            'term' => 'max:225',
            'examYear' => 'date_format:Y',
            'examTerm' => 'max:225',
            'name' => 'max:225',
            'publicName' => 'max:225',
        ];
//
//        $minTerm = Exam::MIN_TERM_LENGTH;
//        $maxTerm = Exam::MAX_TERM_LENGTH;
//        $minName = Exam::MIN_NAME_LENGTH;
//        $maxName = Exam::MAX_NAME_LENGTH;
//        return [
//            'term' => ['required', min($minTerm), max($maxTerm)],
//            'name' => ['required', min($minName), max($maxName)],
//            'year' => ['required', min(4), max(4)]
//        ];
    }
}

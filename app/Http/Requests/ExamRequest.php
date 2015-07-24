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
        //TODO Update to use authorization
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'term' => ['required', min(Exam::MIN_TERM_LENGTH), max(Exam::MAX_TERM_LENGTH)],
            'name' => ['required', min(2), max(200)],
            'year' => ['required', min(4), max(4)]
        ];
    }
}

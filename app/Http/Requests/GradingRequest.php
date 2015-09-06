<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GradingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
     //Todo add authorization
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
            'comment_text' => 'max:10000',

            'elementAssignmentId' => 'integer',
            'element_id' => 'integer',

            'question_assignment_id' => 'integer',
            'questionAssignmentId' => 'integer',

            'score' => 'numeric',
            'student_id' => 'integer',
            'time' => 'numeric',
            
        ];
    }
}

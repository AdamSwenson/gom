<?php

namespace App\Http\Requests;

use App\Exam;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GradingRequest extends Request
{
    const COMMENT_TEXT_MAX_LENGTH = 10000;

    /**
     * Determine if the user is authorized to make this request
     * by checking whether the exam belongs to them.
     *
     * @return bool
     */
    public function authorize()
    {
        $exam = $this->route('exam');
        return $exam->user_id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment_text' => 'max:' . self::COMMENT_TEXT_MAX_LENGTH,

            'element_assignment_id' => 'integer',

            'element_id' => 'integer',

            'question_assignment_id' => 'integer',

            'score' => 'numeric',

            'student_id' => 'required|integer',

            'time' => 'numeric',
        ];
    }
}

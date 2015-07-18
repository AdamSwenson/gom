<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class CreateExamRequest
 *
 * Handles creating a new exam
 *
 * @package App\Http\Requests
 */
class CreateExamRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'term' => 'required',
            'topic' => 'required',
            'year' => ['required', min(4), max(4)]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemScoreRequest extends FormRequest
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
        //todo extend check to make sure records in db
        return [
            'examId' => 'required',
            'itemId' => 'required',
            'studentId' => 'required',
            'score' => 'float',
            'commentText' => 'max:225'

        ];
    }
}

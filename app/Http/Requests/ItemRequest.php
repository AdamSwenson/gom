<?php

namespace App\Http\Requests;

class ItemRequest extends Request
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
        return [
        'idx' => 'array',
            'index' => 'max:225',
            'depth' => 'max:225',
            'maxScore' => 'number|max:225',
            'text' => 'max:225',
            'examid' => 'exams' //check that corresponds to something in the db
        ];
    }
}

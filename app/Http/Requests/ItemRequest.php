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

            'index' => 'required|min:0|max:225',
            'depth' => 'required|min:0|max:225',
            'text' => '',
            'examid' => 'exams' //check that corresponds to something in the db
        ];
    }
}

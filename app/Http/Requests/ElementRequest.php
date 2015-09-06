<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class ElementRequest
 *
 * TODO Setup element request
 *
 * @package App\Http\Requests
 */
class ElementRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo authorization
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
            'elementName' => 'max:225',
            'respGeneric' => 'max:5000',
            'elementId' =>'integer',
            'elementText' => 'max:5000'
        ];
    }
}

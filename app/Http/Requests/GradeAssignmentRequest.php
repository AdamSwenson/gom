<?php

namespace App\Http\Requests;

use App\Exceptions\SilentlyLoggedException;
use App\Http\Requests\Request;

class GradeAssignmentRequest extends Request
{
    /** The substring which all (relevant) incoming fields share */
    const FIELD_BASE = 'gradeGroup';

    /** The highest suffix appended to FIELD_BASE */
    const MAX_SUFFIX = 12;

    /** Message to be displayed if the assignments are intransitive */
    const ERROR_MESSAGE = "The minimum score for a grade cannot be less than the minimum score of any lower grade. Please fix the error and try again";

    /** @var array List of the names and values of incoming fields with non null contents  */
    protected $presentFields = [];


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
        $this->makeValidationRules();
        return $this->rulesArray;
    }


    public function messages()
    {
        return $this->messagesArray;
    }


    /**
     * Since we don't know how many grades will be used, build the validation rules
     * on the fly.
     */
    protected function makeValidationRules()
    {
        $this->buildFieldList();

        if( ! empty($this->presentFields) )
        {
            //Loop over the presentFields and construct rules for all but the last one
            $num = count($this->presentFields) - 1;
            for($i=0; $i<$num; $i++)
            {
                //add a small amount to the next highest grade's minimum score because can't be identical
                $max = $this->presentFields[$i + 1]['minScore'] + 0.001;
                //create the rule for the $ith item
                $this->rulesArray[$this->presentFields[$i]['fieldName']] = 'numeric|min:' . $max;
                //create the message if the rule for the $ith element fails
                $this->messagesArray[$this->presentFields[$i]['fieldName'] . '.min'] = self::ERROR_MESSAGE;
            }
        }
    }

    /**
     * Build list of the names and values of incoming fields with non empty contents
     */
    protected function buildFieldList()
    {
        for($i=0; $i<=self::MAX_SUFFIX; $i++)
        {
            $currentField = self::FIELD_BASE . $i;
            if( ! empty($this->input($currentField)) )
            {
                $this->presentFields[] = ['fieldName' => $currentField, 'minScore' => $this->input($currentField)];
            }
        }
    }
}

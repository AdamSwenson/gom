<?php

namespace App\Http\Requests;

use App\Comment;
use App\Http\Requests\Request;
use App\Exceptions\SilentlyLoggedException;

/**
 * Class ElementRequest
 *
 * @package App\Http\Requests
 */
class ElementRequest extends Request
{

    /** Minimum length of the element name field */
    const ELEMENT_NAME_MIN_LENGTH = 1;

    /** Maximum length of the element name field */
    const ELEMENT_NAME_MAX_LENGTH = 225;

    /** Maximum length of the element text of custom content fields */
    const ELEMENT_TEXT_MAX_LENGTH = 5000;

    /** No question can have more than this number of subtasks. Prevents iterating over massive request*/
    const MAX_SUBTASKS = 50;

    /** @var  integer Count of number of possible comment valences */
    protected static $numberOfValences;

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
        $this->setNumberOfValences();
        $this->makeValidationRules();
        return $this->rulesArray;
    }

    /**
     * Makes sure that the messages will be intelligible to the user
     * @return array
     */
    public function messages()
    {
        return $this->messagesArray;
    }

    /**
     * Requests have variable field names (they are a string plus the subtask number). We don't know
     * how many elements there will be for a question. Thus this runs though the request and builds rules with the
     * appropriate field names.
     */
    public function makeValidationRules()
    {
        $limit = $this->chooseLimit(self::MAX_SUBTASKS, SilentlyLoggedException::REQUEST_MAX_EXCEEDED_ELEMENT);
        for ($i = 0; $i <= $limit; $i++)
        {
            if ($this->has('elementName' . $i))
            {
                //elementId field
                $this->rulesArray['elementId' . $i] = 'integer';

                //elementName field
                $this->rulesArray['elementName' . $i] = 'min:' . self::ELEMENT_NAME_MIN_LENGTH . '|max:' . self::ELEMENT_NAME_MAX_LENGTH;
                $this->messagesArray['elementName' . $i . '.min'] = "The element name for element #$i must be at least :min characters long";
                $this->messagesArray['elementName' . $i . '.max'] = "The element name for element #$i cannot be longer than :max characters";

                //elementText field
                $this->rulesArray['elementText' . $i] = 'max:' . self::ELEMENT_TEXT_MAX_LENGTH;
                $this->messagesArray['elementText' . $i . '.max'] = "The element text for element #$i must be less than :max characters";

                //Construct the rules for each of the valence fields that may be coming in
                for($j=1; $j<= self::$numberOfValences; $j++)
                {
                    $this->rulesArray['e' . $i . 'valence' . $j] = 'max:' . self::ELEMENT_TEXT_MAX_LENGTH;
                    $this->messagesArray['e' . $i . 'valence' . $j] = "One of the custom text entries for element #$i is longer than the allowed :max characters";
                }
            } else
            {
                /*
                 * If the elementName + $i is not in the request and $i is not 0, break out
                 * of the loop. The check for $i = 0 is needed because if the request contains only
                 * pre-existing elements, there will be no 0.
                */
                if ($i > 0)
                {
                    break;
                }
            }
        }
    }


    /**
     * Sets the static property once so that won't have to check the Comment model
     * on every single request.
     */
    protected function setNumberOfValences()
    {
        if(empty(self::$numberOfValences))
        {
            self::$numberOfValences = count( Comment::$valences );
        }
    }
}

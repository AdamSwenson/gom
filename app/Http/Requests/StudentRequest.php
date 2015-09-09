<?php

namespace App\Http\Requests;

use App\Exceptions\SilentlyLoggedException;
use App\Http\Requests\Request;

class StudentRequest extends Request
{

    const LAST_NAME_MIN_LENGTH = 2;

    const LAST_NAME_MAX_LENGTH = 255;

    const FIRST_NAME_MIN_LENGTH = 2;

    const FIRST_NAME_MAX_LENGTH = 255;

    const STUDENT_IDENTIFIER_MAX_LENGTH = 225;

    /** Absolute max number of students that can be added in a request (to help prevent attacks with large numbers) */
    const MAX_STUDENTS = 1000;

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
        $limit = $this->chooseLimit(self::MAX_STUDENTS, SilentlyLoggedException::REQUEST_MAX_EXCEEDED_STUDENT);
        for ($i = 1; $i <= $limit; $i++)
        {
            if ($this->has('lastName' . $i))
            {
                //lastName field
                $this->rulesArray['lastName' . $i] = 'min:' . self::LAST_NAME_MIN_LENGTH . '|max:' . self::LAST_NAME_MAX_LENGTH;
                $this->messagesArray['lastName' . $i . '.min'] = "The last name for student #$i must be at least :min characters long ";
                $this->messagesArray['lastName' . $i . '.max'] = "The last name for student #$i must be less than :max characters long ";

                //firstName field
                $this->rulesArray['firstName' . $i] = 'max:' . self::FIRST_NAME_MAX_LENGTH;
                $this->messagesArray['firstName' . $i . '.max'] = "The first name for student #$i must be less than :max characters long ";

                //studentIdentifier field
                $this->rulesArray['studentIdentifier' . $i] = 'max:' . self::STUDENT_IDENTIFIER_MAX_LENGTH;
                $this->messagesArray['studentIdentifier' . $i . '.max'] = "The student id must be less than :max characters long";

                //email field
                $this->rulesArray['email' . $i] = 'email';
                $this->messagesArray['email' . $i . '.email'] = "The email address for student #$i was invalid";
            } else
            {
                break;
            }
        }
    }
}

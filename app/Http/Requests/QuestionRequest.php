<?php

namespace App\Http\Requests;

use App\Exam;
use App\Http\Requests\Request;
use App\Question;
use App\Exceptions\SilentlyLoggedException;
use Illuminate\Support\Facades\Auth;

/**
 * Class QuestionRequest
 *
 * Holds the incoming form data and handles validation for a question creation request
 *
 * @package App\Http\Requests
 */
class QuestionRequest extends Request
{
    /** Minimum length of question names */
    const QUESTION_NAME_MIN_LENGTH = 1;

    /** Maximum length of question names */
    const QUESTION_NAME_MAX_LENGTH = 225;

    /** Maximum length of the question text */
    const QUESTION_TEXT_MAX_LENGTH = 5000;

    /** Defines an absolute maximum number of questions on an exam to prevent iterating over a massive request */
    const MAX_ITEMS = 100;

    /** @var array Holds the rules which are generated on the fly */
    protected $rulesArray = [];

    /** @var array Holds the messages for the rules which are generated on the fly */
    protected $messagesArray = [];

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
        //prepare validation based on the incoming request
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
     * Requests have variable field names (they are a string plus the question number). We don't know
     * how many questions are on the exam. Thus this runs though the request and builds rules with the
     * appropriate field names.
     */
    public function makeValidationRules()
    {
        $limit = $this->chooseLimit(self::MAX_ITEMS, SilentlyLoggedException::REQUEST_MAX_EXCEEDED_QUESTION);
        for ($i = 0; $i <= $limit; $i++)
        {
            if ($this->has('questionName' . $i))
            {
                $this->rulesArray['questionName' . $i] = 'min:' . self::QUESTION_NAME_MIN_LENGTH . '|max:' . self::QUESTION_NAME_MAX_LENGTH;
                $this->messagesArray['questionName' . $i . '.min'] = "The question name for question #$i must be at least :min characters long";
                $this->messagesArray['questionName' . $i . '.max'] = "The question name for question #$i cannot be longer than :max characters";

                $this->rulesArray['questionId' . $i] = 'integer';

                $this->rulesArray['questionText' . $i] = 'max:' . self::QUESTION_TEXT_MAX_LENGTH;
                $this->messagesArray['questionText' . $i . '.max'] = "The question text for question #$i must be less than :max characters";
            } else
            {
                //If the questionName + $i is not in the request and $i is not 0, break out
                //of the loop. The check for $i = 0 is needed because if the request contains only
                //pre-existing questions, there will be no 0.
                if ($i > 0)
                {
                    break;
                }
            }
        }
    }
}

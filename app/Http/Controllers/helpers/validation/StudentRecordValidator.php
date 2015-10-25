<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/22/15
 * Time: 12:49 PM
 */

namespace App\Http\Controllers\helpers\validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

/**
 * Handles validation of student records when importing.
 * Usual use is to call validateStudents and then use the data in $this->errorMessages,
 * $this->validRecords, and $this->invalidRecords
 *
 * @package Http\Controllers\helpers\validation
 */
class StudentRecordValidator implements IStudentRecordValidator
{

    const LAST_NAME_MIN_LENGTH = 2;

    const LAST_NAME_MAX_LENGTH = 255;

    const FIRST_NAME_MIN_LENGTH = 2;

    const FIRST_NAME_MAX_LENGTH = 255;

    const STUDENT_IDENTIFIER_MAX_LENGTH = 225;

    /** Absolute max number of students that can be added in a request (to help prevent attacks with large numbers) */
    const MAX_STUDENTS = 1000;

    /** @var  MessageBag  Holds error messages from validation */
    public $errorMessages;

    /** @var array When a request to alter students comes in, this holds records which pass validation */
    public $validRecords = [];

    /** @var array When a request to alter students comes in, this holds records which fail validation */
    public $invalidRecords = [];


    /**
     * Validates student records in incoming request.
     * If it is valid, adds the row identifier to the $this->validRecords array
     * If not valid, adds the row identifier to the $this->invalidRecords array and
     * adds the applicable error messages to $this->errorMessages.
     * @param Request $request
     */
    public function validateStudents(Request $request)
    {
        //Create a new message bag instance
        //TODO: Load this via ioc or otherwise decouple
        $this->errorMessages = new MessageBag();

        for ($i = 1; $i <= $this->chooseLimit($request); $i++)
        {

             /*
              * At least one of the fields needs to be set to even attempt validation.
              * This is important because $this->chooseLimit just counted the number keys in
              * the incoming array. So $i will keep increasing until it hits #rows * #fields.
              * Without this check, we would spuriously get values of $i added to the validRecords
              * array which are not in the request.
              */
            if ( $request->has('lastName' . $i)
                || $request->has('firstName' . $i)
                || $request->has('email' . $i)
                || $request->has('studentIdentifier' . $i)
                || $request->has('id' . $i) )
            {
                //Prepare the rules and messages for the incoming record
                $rules = $this->makeValidationRules($i);

                if ($request->has('lastName' . $i) && $request->has('firstName' . $i))
                {
                    $name = $request->input('lastName' . $i) . ', ' . $request->input('firstName' . $i);
                } else
                {
                    $name = '';
                }

                $messages = $this->makeMessages($i, $name);

                //Pull out a record from the incoming request
                $incomingStudent = [];
                $incomingStudent['lastName' . $i] = $request->input('lastName' . $i);
                $incomingStudent['firstName' . $i] = $request->input('firstName' . $i);
                $incomingStudent['email' . $i] = $request->input('email' . $i);
                $incomingStudent['studentIdentifier' . $i] = $request->input('studentIdentifier' . $i);
                $incomingStudent['id' . $i] = $request->input('id' . $i);

                $validator = Validator::make($incomingStudent, $rules, $messages);

                if (!$validator->fails())
                {
                    //The record passes validation. Add its order number to the validRecords array
                    $this->validRecords[] = $i;
                } else
                {
                    /* The record failed validation, so we need to send it back to the user for revision.
                     * We'll do this by storing the row number of the record and the failure message.
                     *
                     * First, we add its order number to the invalidRecords array
                     */
                    $this->invalidRecords[] = $i;

                    /* The flash messaging system will want a MessageBag object. But each validator instance will have
                     * its own message bag. So we'll pull out each message from the current validator's bag and store it
                     * in the controller's message bag (i.e., $this->errorMessages).
                     */
                    $messageBag = $validator->getMessageBag();
                    foreach ($messageBag->all() as $key => $value)
                    {
                        $this->errorMessages->add($key, $value);
                    }
                }
            }
        }
    }

    /**
     * Requests have variable field names (they are a string plus the subtask number). We don't know
     * how many elements there will be for a question. Thus this runs though the request and builds rules with the
     * appropriate field names.
     * @param $i The row number to make the rule for
     * @return array
     */
    protected function makeValidationRules($i)
    {
        $rulesArray = [];

        //lastName field
        $rulesArray['lastName' . $i] = 'required|min:' . self::LAST_NAME_MIN_LENGTH . '|max:' . self::LAST_NAME_MAX_LENGTH;

        //firstName field
        $rulesArray['firstName' . $i] = 'required|max:' . self::FIRST_NAME_MAX_LENGTH;

        //studentIdentifier field
        $rulesArray['studentIdentifier' . $i] = 'max:' . self::STUDENT_IDENTIFIER_MAX_LENGTH;

        //email field
        $rulesArray['email' . $i] = 'email';

        return $rulesArray;
    }

    /**
     * Build the messages in case row $i's student record proves invalid
     * @param $i
     * @param $studentName
     * @return array
     */
    protected function makeMessages($i, $studentName)
    {
        $messagesArray = [];

        //lastName field
        $messagesArray['lastName' . $i . '.min'] = "We could not record '$studentName' to the database. Their last name must be at least :min characters long ";
        $messagesArray['lastName' . $i . '.max'] = "We could not record '$studentName' to the database. Their last name must be less than :max characters long ";
        $messagesArray['lastName' . $i . '.required'] = "We could not record row #'$i' to the database. Their last name is required";

        //firstName field
        $messagesArray['firstName' . $i . '.min'] = "We could not record '$studentName' to the database. Their first name must be at least :min characters long ";
        $messagesArray['firstName' . $i . '.max'] = "We could not record '$studentName' to the database. Their first name must be less than :max characters long ";

        //studentIdentifier field
        $messagesArray['studentIdentifier' . $i . '.max'] = "We could not record '$studentName' to the database. Their student id must be less than :max characters long";

        //email field
        $messagesArray['email' . $i . '.email'] = "We could not record '$studentName' to the database. Their email address (if one is provided) must be valid";

        return $messagesArray;
    }

    /**
     * We don't want to just iterate over a count of the incoming request.
     * This helps defend against an attack where someone passes a huge incoming request to
     * eat up system resources.
     *
     * If the number of incoming items is less than the max allowed, iterate through
     * the count of the incoming items. Otherwise limit the iteration to the defined maximum.
     *
     * @param Request $request
     * @return int
     * @internal param int $maxItems The absolute maximum number of allowed items
     */
    protected function chooseLimit(Request $request)
    {
        $incomingCount = count($request->all());
        if ($incomingCount < self::MAX_STUDENTS)
        {
            return $incomingCount;
        }
        //  throw new SilentlyLoggedException($type, " Incoming count was: $incomingCount. Allowed maximum was" . self::MAX_STUDENTS);
        return self::MAX_STUDENTS;
    }

}
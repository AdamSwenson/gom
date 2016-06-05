<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/1/15
 * Time: 3:11 PM
 */

namespace App\Repositories\Feedback;

use App\AccessKey;
use App\Exceptions\FeedbackCreationException;
use App\Exceptions\InputTypeException;
use App\Feedback;
use App\Repositories\Feedback\PseudoIDMaker;
use App\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AccessKeyRepository
 *
 * Handles checking if access key is already in use, creating a key, checking
 * whether a key is valid on login, and destroying keys.
 *
 * @package Repositories\Feedback
 */
class AccessKeyRepository implements IAccessKeyRepository
{

    const TRIM_TO_LENGTH = 1000;

    protected $validKey;

    /**
     * Creates an access key, checks its validity, and records it in the database.
     * If there is already an existing key for the exam/student combo, will return the
     * existing key unless $forceNew is true
     *
     * Returns only the string, not the model object.
     *
     * TODO: Improve localization so that expiration date will occur as expected
     *
     * @param $examId
     * @param $studentId
     * @param int $daysUntilExpiration
     * @param bool $forceNew
     * @return string
     * @throws FeedbackCreationException
     */
    public function createAccessKey($examId, $studentId, $daysUntilExpiration = 10, $forceNew = false)
    {
        //make a new hash
        $accessHash = $this->generateNewKey();
        if ( $accessHash )
        {
            $expire = Carbon::now()->addDays($daysUntilExpiration);

            $k = AccessKey::firstOrNew(['exam_id' => $examId, 'student_id' => $studentId]);

            //Keep the existing key if one already exists
            //of if have been instructed to create a new access key
            if ( empty($k->access_key) || $forceNew )
            {
                $k->setKey($accessHash);
            }

            $k->setExamId($examId);
            $k->setStudentId($studentId);
            $k->setExpirationDate($expire);

            //save student info so don't have to look up from feedback processes
            $student = Student::loggedIn()
                ->where('id', $studentId)->firstOrFail();
            $name = $student->getFullName() ? $student->getFullName() : '';
            $id = $student->student_identifier ? $student->student_identifier : '';
            $k->student_info = [
                'studentName'       => $name,
                'studentIdentifier' => $id,
            ];

            $k->save();

            if ( $k )
            {
                return $k->getKey();
            }
        }
        throw new FeedbackCreationException(FeedbackCreationException::ACCESS_KEY_CREATION);
    }


    /**
     * Removes an access key (and associated feedback) from storage
     *
     * @param string $accessKey
     */
    public function removeAccessKey($accessKey)
    {
        $key = AccessKey::where('access_key', $accessKey)->firstOrFail();

        return $key->delete();
    }

    /**
     * Deletes all access keys and feedback for the exam.
     * Students will no longer be able to access their feedback.
     *
     * If feedback is rebuilt after calling this, there will be all new access keys
     *
     * @param integer $examId
     * @return boolean
     */
    public function removeAccessForExam($examId)
    {
        return AccessKey::where('exam_id', $examId)->delete();
    }

    /**
     * Removes the access key and feedback for the exam for a single student.
     * That student will no longer be able to access their feedback.
     *
     * If feedback is rebuilt after calling this, the student will have a new access key
     *
     * @param integer $examId
     * @param integer $studentId
     * @return boolean
     */
    public function removeAccessForStudent($examId, $studentId)
    {
        return AccessKey::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->delete();
    }

    /**
     * Loads the stored feedback by access key
     * @param $accessKey
     * @return array
     */
    public function retrieveFeedback($accessKey)
    {
        $this->validateKey($accessKey);
        if ( ! empty($this->validKey) )
        {
            return $this->loadFeedback();
        }
    }

    /**
     * Looks up the access key for a student.
     *
     * Note that the query is automatically limited to the present user. Therefore,
     * do not try to use this to check that a key is unique for all users.
     *
     * @param $examId
     * @param $studentId
     * @return string The access key for the student
     */
    public function getAccessKeyForStudent($examId, $studentId)
    {
        $key = AccessKey::where('exam_id', $examId)->where('student_id', $studentId)->first();
        if ( ! empty($key) )
        {
            return $key->getKey();
        }

        return null;
    }


    /**
     * Returns an array of information about the student given the access key
     * Array keys: studentName, studentIdentifier
     * @param $accessKey
     * @return array
     */
    public function getStudentInfo($accessKey)
    {
        //if had the object passed in for some weird reason
        if ( $accessKey instanceof AccessKey )
        {
            return $accessKey->student_info;
        }
        //it's a string as usual
        $this->validateKey($accessKey);
        if ( ! empty($this->validKey) )
        {
            $key = AccessKey::where('access_key', $accessKey)->first();

            return $key->student_info;
        }

        return null;

//        $name = $key->student->getFullName() ? $key->student->getFullName() : '';
//        $id = $key->student->student_identifier ? $key->student->student_identifier : '';
//        return [ 'studentName' => $name,
//                 'studentIdentifier' => $id,
//        ];
    }

    /**
     * Loads all access keys for a given exam
     * @param $examId
     */
    public function getAccessKeysForExam($examId)
    {
        return AccessKey::onExam($examId)->get();
    }


    /**
     * Helper to check if an incoming key has the properties of an access key.
     * Does not actually check if the key exists in the database
     *
     * @param $accessKey
     * @return mixed
     * @throws InputTypeException
     */
    protected function validateKey($accessKey)
    {
        //Remove whitespace
        $trimmed = \trim($accessKey);

        //Check that not longer than allowed length
        if ( \mb_strlen($trimmed) <= self::TRIM_TO_LENGTH )
        {
            //Clean it to make sure it is just nice stringy goodness
            $cleaned = \filter_var($trimmed, \FILTER_SANITIZE_STRING);
        }

        if ( ! empty($cleaned) )
        {
            $this->validKey = $cleaned;

            return $this->validKey;
        }

        throw new InputTypeException(InputTypeException::STRING);
    }

    /**
     * Actually gets the feedback from storage
     * @return Feedback
     */
    protected function loadFeedback()
    {
        if ( ! empty($this->validKey) )
        {
            //TODO do I need to throw an exception manually if it doesn't find?
            $feedback = Feedback::where('access_key', $this->validKey)->first();;
            if ( $feedback )
            {
                return $feedback;
            }
            $e = new ModelNotFoundException();
            $e->setModel(Feedback::class);
            throw $e;
        }

        return null;
    }

    /**
     * Creates a unique key
     *
     * @return string The candidate pseudoID
     */
    protected function generateNewKey()
    {
        $candidate = $this->createCandidateKey();
        if ( $this->checkIfKeyIsUnique($candidate) )
        {
            return $candidate;
        }
    }

    /**
     * Checks whether candidate key is unique.
     * Note that this checks across all users
     * @param $candidate
     * @return bool
     */
    protected function checkIfKeyIsUnique($candidate)
    {
        $key = DB::table('access_keys')->where('access_key', $candidate)->first();
        if ( empty($key) )
        {
            return $candidate;
        }

        return false;
    }

    /**
     * Generates a potential key ready to be  checked for uniqueness
     * @return mixed
     */
    protected function createCandidateKey()
    {
        $candidate = hash('sha256', \openssl_random_pseudo_bytes(AccessKey::LOOKUP_SIZE));

        return $candidate;
    }
}
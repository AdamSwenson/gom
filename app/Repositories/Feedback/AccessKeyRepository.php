<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/1/15
 * Time: 3:11 PM
 */

namespace App\Repositories\Feedback;

use App\AccessKey;
use App\Exceptions\InputTypeException;
use App\Feedback;
use App\Repositories\Feedback\PseudoIDMaker;
use Carbon\Carbon;
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


    protected $validKey;

    /**
     * Creates an access key, checks its validity, and records it in the database.
     * Returns only the string, not the model object.
     *
     * TODO: Improve localization so that expiration date will occur as expected
     *
     * @param $examId
     * @param $studentId
     * @param int $daysUntilExpiration
     * @return string
     */
    public function createAccessKey($examId, $studentId, $daysUntilExpiration=10)
    {
        $accessKey = $this->generateNewKey();
        if($accessKey)
        {
            $expire = Carbon::now()->addDays($daysUntilExpiration);
            $k = new AccessKey();
            $k->setKey($accessKey);
            $k->setExamId($examId);
            $k->setStudentId($studentId);
            $k->setExpirationDate($expire);
            $k->save();

            if($k)
            {
                return $k->getKey();
            }
        }
    }


    /**
     * Loads the stored feedback by access key
     * @param $accessKey
     * @return array
     */
    public function retrieveFeedback($accessKey)
    {
        $this->validateKey($accessKey);
        if(!empty($this->validKey))
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
        return $key->getKey();
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
     * Helper to check if an incoming key has the properties of an access key
     *
     * @param $accessKey
     * @return mixed
     * @throws InputTypeException
     */
    protected function validateKey($accessKey)
    {
     //   dd($accessKey);
        $trimmed = \trim($accessKey);
       // dd($trimmed);
        $cleaned = \filter_var($trimmed, \FILTER_SANITIZE_STRING);
        //dd($cleaned);
        if(!empty($cleaned))
//        if((!empty($cleaned)) && (\mb_strlen($cleaned) === AccessKey::LOOKUP_SIZE))
        {
            $this->validKey = $cleaned;
            return $this->validKey;
        }
        else{
            throw new InputTypeException(InputTypeException::STRING);
        }
    }

    /**
     * Actually gets the feedback from storage
     * @return array
     */
    protected function loadFeedback()
    {
        if(!empty($this->validKey))
        {
//            echo 'j';
//Todo: Implement loader of feedback
            $data = Feedback::findOrFail($this->validKey);
            return $data;

        }
    }


    /**
     * Creates a unique key
     *
     * @return string The candidate pseudoID
     */
    protected function generateNewKey()
    {
        $candidate = $this->createCandidateKey();
        if($this->checkIfKeyIsUnique($candidate))
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
        if(empty($key))
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
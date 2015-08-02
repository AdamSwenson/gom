<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 1:19 PM
 */
namespace App\Repositories\Feedback;


/**
 * Class AccessKeyRepository
 *
 * Handles checking if access key is already in use, creating a key, checking
 * whether a key is valid on login, and destroying keys.
 *
 * @package Repositories\Feedback
 */
interface IAccessKeyRepository
{

    /**
     * Creates an access key, checks its validity, and records it in the database.
     * Returns only the string, not the model object.
     * @param $examId
     * @param $studentId
     * @return string
     */
    public function createAccessKey($examId, $studentId);

    /**
     * Loads the stored feedback by access key
     * @param $accessKey
     * @return array
     */
    public function retrieveFeedback($accessKey);

    /**
     * Removes an access key (and associated feedback) from storage
     *
     * @param string $accessKey
     */
    public function removeAccessKey($accessKey);


    /**
     * Loads all access keys for a given exam
     * @param $examId
     */
    public function getAccessKeysForExam($examId);

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
    public function getAccessKeyForStudent($examId, $studentId);
}
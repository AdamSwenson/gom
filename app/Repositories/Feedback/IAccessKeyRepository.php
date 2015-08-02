<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 1:19 PM
 */
namespace Repositories\Feedback;


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
     * Determines whether a key is already in use
     * @param $potentialKey
     * @return boolean
     */
    public function checkIfKeyIsUnique($potentialKey);

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
}
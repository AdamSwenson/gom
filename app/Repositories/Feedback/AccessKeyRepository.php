<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/1/15
 * Time: 3:11 PM
 */

namespace Repositories\Feedback;

use App\Exceptions\InputTypeException;
use App\Repositories\Feedback\PseudoIDMaker;

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
     * Determines whether a key is already in use
     * @param $potentialKey
     * @return boolean
     */
    public function checkIfKeyIsUnique($potentialKey)
    {
        $this->validateKey($potentialKey);
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
     * Removes an access key (and associated feedback) from storage
     *
     * @param string $accessKey
     */
    public function removeAccessKey($accessKey)
    {}

    /**
     * Helper to check if an incoming key has the properties of an access key
     *
     * @param $accessKey
     * @return mixed
     * @throws InputTypeException
     */
    protected function validateKey($accessKey)
    {
        $trimmed = \trim($accessKey);
        $cleaned = \filter_var($trimmed, \FILTER_SANITIZE_STRING);
        if((!empty($cleaned)) && (\mb_strlen($cleaned) === PseudoIDMaker::LOOKUP_SIZE))
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
//Todo: Implement loader of feedback
        }
    }
}
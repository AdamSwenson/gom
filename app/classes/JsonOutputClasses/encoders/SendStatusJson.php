<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace JsonOutputClasses\encoders;

/**
 * This encodes, packages, and sends a response to javascript requests expecting a report on the status of a request.
 * Such applications are expecting a json object with the form
 *  {"status":[{"status":"success"|"fail", "message":"custom message"|"success"|"fail"}]
 *
 * @author adam
 */
class SendStatusJson extends JsonEncoderParent implements IJsonOutput
{
    const SUCCESS_STATUS = 'success';
    const FAILURE_STATUS = 'fail';
    const DEFAULT_SUCCESS_MESSAGE = 'success';
    const DEFAULT_FAILURE_MESSAGE = 'fail';

    /** @var STATUSFLAG  This is the key that should be present in any database response which is to be returned as a status message. This should be absent in all those which are to be returned as data */
    const STATUSFLAG = "numrows";

    /** @var MESSAGEFLAG The key of the response array if a message is to be returned to the browse */
    const MESSAGEFLAG = 'message';

    /** @var $message QuerySuccessHandler The message to be returned */
    public $message;

    /** @var $status QuerySuccessHandler The status */
    public $status;

    /** @var $response QuerySuccessHandler The response message */
    public $response;

    /**
     * This takes an array with the key 'numrows' and optionally a key 'message', constructs the response, and sends to the client
     * @param array $result
     */
    public function encode_and_send(array $result)
    {
        if (count($result) > 0) {
            $this->determine_status($result);
            $this->determine_message($result);
            $response = $this->prepare_array();
            $escaped = $this->escape_array_contents($response);
            $packaged = $this->package($escaped);
            $this->encode($packaged);
            $this->send();
        }
    }

    /**
     * This is used to construct json objects for things expecting a report of whether a request
     * executed properly
     *
     * @param  array $array_to_package
     * @return array
     */
    protected function package(array $array_to_package)
    {
        $packaged = array(parent::STATUS_RESPONSE_KEY => $array_to_package);

        return $packaged;
    }

    /**
     * Checks whether a custom message has been passed in. If so, sets it as the message to be returned
     */
    protected function determine_message(array $dbresponse)
    {
        if (array_key_exists(self::MESSAGEFLAG, $dbresponse)) {
            $this->message = $dbresponse[self::MESSAGEFLAG];
        }
    }

    /**
     * Checks for the number of affected rows and sets status accordingly
     * @param array $dbresponse
     */
    protected function determine_status(array $dbresponse)
    {
        if (array_key_exists(self::STATUSFLAG, $dbresponse)) {
            if ($dbresponse[self::STATUSFLAG] >= 1) {
                $this->status = self::SUCCESS_STATUS;
            } else {
                $this->status = self::FAILURE_STATUS;
            }
        }
    }

    /**
     * Builds the response array. Checks first if the message is already set. If not, sets default message given the status.
     * If there is a non-standard status and message not set, will use default fail message
     */
    protected function prepare_array()
    {
        if (!isset($this->message)) {
            switch ($this->status) {
                case 'success':
                    $this->message = self::DEFAULT_SUCCESS_MESSAGE;
                    break;
                case 'fail':
                    $this->message = self::DEFAULT_FAILURE_MESSAGE;
                    break;
                default:
                    $this->message = self::DEFAULT_FAILURE_MESSAGE;
                    break;
            }
        }

        return array('status' => $this->status, 'message' => $this->message);
    }

}

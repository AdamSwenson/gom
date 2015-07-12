<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace JsonOutputClasses\encoders;

/**
 * This is the parent class for the everything which encodes and sends messages as json objects.
 * It contains methods for safely encoding the outgoing item and packaging it in ways expected by the javascript.
 * Child classes handle the actual packaging and encoding method calls.
 *
 * It also reports errors in encoding to log
 *
 * Everything which outputs json objects should be made to use its children.
 *
 * @author adam
 */
abstract class JsonEncoderParent
{
    /** @var STATUS_RESPONSE_KEY The main key of the json expected by requests wanting status report */
    const STATUS_RESPONSE_KEY = 'status';
    /** @var DATA_RESPONSE_KEY The main key of the json expected by requests wanting data */
    const DATA_RESPONSE_KEY = 'data';

    /** @var DEFAULT_ERROR_STATUS The error status to report to the user in the event of an encoding error */
    const DEFAULT_ERROR_STATUS = 'fail';
    /** @var DEFAULT_ERROR_MESSAGE The error message to report to the user in the event of an encoding error */
    const DEFAULT_ERROR_MESSAGE = 'fail';

    /** @var $result Unencoded array */
    protected $result;

    /** @var $encoded Encoded array for sending */
    protected $encoded;

//    /** @var $logger \SecurityClasses\logging\ISecurityLoggers Logger for encoding */
//    protected $logger;
//
//    /**
//     * Loads an appropriate logger
//     * @param \SecurityClasses\logging\ISecurityLoggers $logger
//     */
//    public function set_logger(\SecurityClasses\logging\ISecurityLoggers $logger)
//    {
//        $this->logger = $logger;
//    }

    /**
     * This is used to create an array with the structure the javascript making the request is expecting
     * of the proper format the results in the way javascript is expecting oconstruct json objects for things expecting a report of whether a request
     * executed properly
     *
     * @param  array $array_to_package
     * @return array
     */
    abstract protected function package(array $array_to_package);

    /**
     * Give this the result and it will encode and send it, all done.
     * @param array $result The result from the db
     */
    abstract public function encode_and_send(array $result);

    /**
     * Escapes the value fields of an array for html output and won't be run in an attack
     *
     * @todo Needs to be fixed for deeper arrays
     *
     * @param  array $array_to_escape
     * @return array
     */
    public function escape_array_contents(array $array_to_escape)
    {
        return $array_to_escape;
//        try {
////        $encoded_array = array();
//        if (count($array_to_escape) > 0) {
//            array_walk_recursive($array_to_escape, function ($v, $k) {return htmlentities($v, ENT_QUOTES, "UTF-8");});
////            foreach ($array_to_escape as $k => $v) {
////                $encoded_array[$k] = htmlentities($v, ENT_QUOTES, "UTF-8");
////            }
//        }
//        return $array_to_escape;
////        return $encoded_array;
//        } catch (\Exception $e) {
//            $this->error_handler($e->getLine(), $e->getMessage(), $e->getTraceAsString());
//        }
    }

    /**
     * Handles the encoding into json object. Uses JSON_FORCE_OBJECT flag to make sure that content won't be run by html parser
     * Sets the $encoded array if successful. This is the last step before sending.
     * @param array $array_to_encode
     */
    public function encode(array $array_to_encode)
    {
        $encoded = json_encode($array_to_encode, \JSON_FORCE_OBJECT);
        switch (json_last_error()) {
            case JSON_ERROR_NONE: //data UTF-8 compliant
                $this->encoded = $encoded;
                break;
            case JSON_ERROR_SYNTAX:
            case JSON_ERROR_UTF8:
            case JSON_ERROR_DEPTH:
            case JSON_ERROR_STATE_MISMATCH:

            case JSON_ERROR_CTRL_CHAR:
                $this->error_handler(__LINE__, json_last_error(), json_last_error_msg());
                break;
            default:
                $this->error_handler(__LINE__, 'JSON encode error', 'Unknown error');
                break;
        }
    }

    /**
     * Logs failure of json encoding to a private log and sets $this->encoded to an error message ready to be sent to user.
     * @param type $lineNum
     * @param type $jError
     * @param type $jMsg
     */
    public function error_handler($lineNum, $jError, $jMsg)
    {
        $msg = "Error w json encoding at line $lineNum  \nError is $jError \n Error message: $jMsg";
        if (isset($this->logger)) {
            $this->logger->securityEvent($msg);
        } else {
            \error_log($msg);
        }
        $this->set_error_message();
    }

    /**
     * Prepares error object to be sent to user
     */
    public function set_error_message()
    {
        $response = array('status' => self::DEFAULT_ERROR_STATUS, 'message' => self::DEFAULT_ERROR_MESSAGE);
        $this->encoded = json_encode($response);
    }

    /**
     * Sends header to inform that json coming, then echos json
     *
     * @throws \Exception
     */
    public function send()
    {
        if ($this->encoded) {
            header("Content-type:application/json; charset = utf-8");
            echo $this->encoded;
        } else {
            throw new \Exception("Send called without encoded property set", 9002);
        }
    }

}

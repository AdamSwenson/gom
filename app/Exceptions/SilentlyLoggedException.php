<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/7/15
 * Time: 11:43 AM
 */

namespace App\Exceptions;

use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;

/**
 * Class SilentlyLoggedException
 *
 * This is thrown when an event we wish to monitor occurs. It logs the message, but
 * does not interrupt processing or notify the user.
 *
 * One main use is determining whether a setting is appropriate.
 * For example, this is thrown when the max students allowed to be uploaded is exceeded.
 * If we get a lot of users trying to upload more than the max, we should adjust the max.
 *
 * @package Exceptions
 */
class SilentlyLoggedException extends CustomException
{
    const REQUEST_MAX_EXCEEDED_QUESTION = 100;
    const REQUEST_MAX_EXCEEDED_ELEMENT = 101;
    const REQUEST_MAX_EXCEEDED_STUDENT = 102;


    static public $messages = [
        "default" => "Unspecified error with input type occurred",
        self::REQUEST_MAX_EXCEEDED_QUESTION => "A request with too many questions was received. ",
        self::REQUEST_MAX_EXCEEDED_ELEMENT => "A request with too many elements was received. ",
        self::REQUEST_MAX_EXCEEDED_STUDENT=> "A request with too many students was received. ",
    ];

    /**
     * @param null $type One of the constants to determine exception type
     * @param null $additionalInfo
     */
    public function __construct($type=null, $additionalInfo=null)
    {
        $message = $this->chooseMessage($type);
        $message .= $additionalInfo;
        $this->logMessage($message);
    }

    /**
     * Handles logging
     * TODO: Set up channel for this sort of log
     * @param $message
     */
    public function logMessage($message)
    {
        $originatingUser = \Auth::user();
        $toLog = "[" . __CLASS__ . "] [From user_id: {$originatingUser->id}] " . $message;
        \error_log($toLog);
    }

}
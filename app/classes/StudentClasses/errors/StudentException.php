<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 4:35 PM
 */

namespace classes\StudentClasses\errors;


use Exceptions\CustomException;

class StudentException extends CustomException
{

    const INVALID_AUTOCOMPLETE = 100;

    static public $messages = [
        "default" => "Unspecified credential error occurred",
        self::INVALID_AUTOCOMPLETE => "Error in request for autocomplete lookup"

    ];

}
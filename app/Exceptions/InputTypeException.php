<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 7:54 AM
 */

namespace App\Exceptions;


class InputTypeException extends CustomException
{
    const STRING = 100;
    const STRING_TOO_LONG = 101;

    const INTEGER = 200;
    const INTEGER_TOO_LONG = 201;
    const INTEGER_NON_NUMERIC = 202;

    const FLOAT = 300;
    const FLOAT_TOO_LONG = 301;
    const FLOAT_NON_NUMERIC = 302;

    const EMAIL = 400;

    static public $messages = [
        "default" => "Unspecified error with input type occurred",
        self::STRING => "Error validating string",
        self::STRING_TOO_LONG => "String is too long",
        self::INTEGER => "Error validating integer",
        self::INTEGER_NON_NUMERIC => "Non numeric thing pretending to be an integer",
        self::INTEGER_TOO_LONG => "Integer is too big",
        self::FLOAT => "Error validating or sanitizing float",
        self::FLOAT_TOO_LONG => "Float is too big",
        self::FLOAT_NON_NUMERIC => "Non numeric thing pretending to be a float",
        self::EMAIL => "Error validating email"
    ];

}
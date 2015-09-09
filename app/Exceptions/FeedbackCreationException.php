<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/1/15
 * Time: 11:41 AM
 */

namespace App\Exceptions;


class FeedbackCreationException extends CustomException
{
    const ACCESS_KEY_CREATION = 100;

    static public $messages = [
        "default" => "Unspecified error with feedback creation occurred",
        self::ACCESS_KEY_CREATION => "Error creating access key"
    ];

}
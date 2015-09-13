<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/12/15
 * Time: 5:37 PM
 */

namespace App\Exceptions;


class UnpermittedDomainException extends \Exception
{

    public function __construct($domain)
    {
        $this->logAttemptedDomain($domain);
    }

    public function logAttemptedDomain($domain)
    {
        $toLog = "[" . __CLASS__ . "] [AttemptedRegistration] Domain " . $domain;
        \error_log($toLog);
    }

}
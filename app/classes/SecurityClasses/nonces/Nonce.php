<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\SecurityClasses\nonces;

/**
 * This performs validation operations and is expected by the various nonce handlers
 *
 * @author adam
 */
class Nonce
{
    const MAX_LENGTH = 100;

    protected $token;

    protected $time;

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Sets the values after checking for type and length
     * @param  type       $name
     * @param  type       $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        try {
            switch ($name) {
        case 'token' :
            if (ctype_alnum($value) && (mb_strlen($value) <= self::MAX_LENGTH)) {
            $this->token = $value;
            } else {
                throw new \Exception("Invalid incoming value for nonce");
            }
            break;
        case 'time':
            if (filter_var($value, \FILTER_VALIDATE_INT)) {
                $this->time = intval($value);
            } else {
                throw new \Exception("Invalid string passed for time");
            }
            break;
        default:
            throw new \Exception("Invalid property attempting to be set");
            break;
        }
        } catch (\Exception $e) { throw $e;}
    }

}

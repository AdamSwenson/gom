<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

use App\Exceptions\InputTypeException;

/**
 * Validates and or cleans email strings 
 *
 * @author adam
 */
class EmailCleaner implements ICleaner {

    const MAX_LENGTH = 200;

    protected $max_length;

    /**
     * Cleans email address
     * @param type $to_clean
     * @param $max_length
     * @return bool
     * @throws InputTypeException
     */
    public function sanitize($to_clean, $max_length) {
        if ($this->validate($to_clean)) {
            $email = \filter_var($to_clean, \FILTER_SANITIZE_EMAIL); //now has valid for email characters
            $cleanish = \trim($email);
            if((!empty($max_length)) && (\mb_strlen($cleanish) > $max_length))
            {
                throw new InputTypeException(InputTypeException::EMAIL);
            }
            return $cleanish;
        } else {
            throw new InputTypeException(InputTypeException::EMAIL);
//            return FALSE;
        }
    }

    /**
     * Returns false if invalid or longer than max length
     * @param type $to_validate
     * @return boolean
     */
    public function validate($to_validate) {
        if (mb_strlen($to_validate) <= self::MAX_LENGTH) {
            return filter_var($to_validate, FILTER_VALIDATE_EMAIL);
        } else {
            return FALSE;
        }
    }

    public function set_max_length($custom_max) {
        $this->max_length = $custom_max;
    }

}

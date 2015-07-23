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
class EmailCleaner implements ICleaner
{

    const MAX_LENGTH = 200;

    protected $max_length;

    /**
     * Cleans email address
     * @param type $to_clean
     * @param $max_length
     * @return bool
     * @throws InputTypeException
     */
    public function sanitize($to_clean, $max_length = null)
    {
        if ($this->validate($to_clean, $max_length))
        {
            $cleanish = \trim($to_clean);
            $this->checkLength($cleanish, $max_length);
            $email = \filter_var($cleanish, \FILTER_SANITIZE_EMAIL); //now has valid for email characters
            return $email;
        }else{
            throw new InputTypeException(InputTypeException::EMAIL);
        }
    }

    /**
     * Returns false if invalid or longer than max length
     * @param type $to_validate
     * @param $max_length
     * @return bool
     */
    public function validate($to_validate, $max_length = null)
    {
        try
        {
            $this->checkLength($to_validate, $max_length);
            return \filter_var($to_validate, \FILTER_VALIDATE_EMAIL);
        } catch (\Exception $e)
        {
            return false;
        }
    }

    protected function checkLength($to_clean, $max_length = null)
    {
        if ((!empty($max_length)) && (\mb_strlen($to_clean) > $max_length))
        {
            throw new InputTypeException(InputTypeException::EMAIL);
        }
    }


    public function set_max_length($custom_max)
    {
        $this->max_length = $custom_max;
    }

}

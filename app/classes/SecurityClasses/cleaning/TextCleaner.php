<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

use App\Exceptions\InputTypeException;

/**
 * Cleaner for standard text. Pretty much a dummy right now
 * 
 * @todo Implement everything
 *
 * @author adam
 */
class TextCleaner implements ICleaner {

    const MAX_LENGTH = 200;

    protected $max_length;

    /**
     * Cleans text. Runs striptags and htmlspecialchars
     * @param type $to_clean
     * @param $max_length
     * @return string
     * @throws InputTypeException
     */
    public function sanitize($to_clean, $max_length=null) {
        $cleanish = \trim($to_clean);
        $this->checkLength($to_clean, $max_length);
        $cleaner = \filter_var($cleanish, \FILTER_SANITIZE_STRING);
        return $cleaner;
    }

    protected function checkLength($to_clean, $max_length=null)
    {
        if((!empty($max_length)) && (\mb_strlen($to_clean) > $max_length))
        {
            throw new InputTypeException(InputTypeException::STRING_TOO_LONG);
        }
    }


    /**
     * Returns false if invalid or longer than max length
     * @param type $to_validate
     * @param $max_length
     * @return bool
     */
    public function validate($to_validate, $max_length=null) {
        try{
            $this->checkLength($to_validate, $max_length);
        }catch(\Exception $e){
            return false;
        }
        return $to_validate;
    }

    public function set_max_length($custom_max) {
        $this->max_length = $custom_max;
    }

}

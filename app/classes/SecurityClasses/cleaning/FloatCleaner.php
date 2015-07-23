<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

use App\Exceptions\InputTypeException;

/**
 * Handles both float and string representation of a float
 *
 * @author adam
 */
class FloatCleaner implements ICleaner
{
    const MAX_LENGTH = 100;
    
    protected $max_length;
    
    public function sanitize($to_clean, $max_length=null) {
         if (!is_numeric($to_clean))
         {
             throw new InputTypeException(InputTypeException::FLOAT_NON_NUMERIC);
         }
        if (is_string($to_clean)) {
            $to_clean = (float) $to_clean;
        }
         $this->checkLength($to_clean, $max_length);
        return \filter_var($to_clean, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);
    }

    protected function checkLength($to_clean, $max_length = null)
    {
        if (!empty($max_length) && ($to_clean > $max_length))
        {
            throw new InputTypeException(InputTypeException::FLOAT_TOO_LONG);
        }
    }


    public function validate($to_validate, $max_length=null)
    {
        return \filter_var($to_validate, \FILTER_VALIDATE_FLOAT);
    }
    
    public function set_max_length($custom_max)
    {
        $this->max_length = $custom_max;
    }
}

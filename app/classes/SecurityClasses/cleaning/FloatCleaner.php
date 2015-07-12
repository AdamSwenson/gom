<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace SecurityClasses\cleaning;

/**
 * Handles both float and string representation of a float
 *
 * @author adam
 */
class FloatCleaner implements ICleaner
{
    const MAX_LENGTH = 100;
    
    protected $max_length;
    
    public function sanitize($to_clean) {
         if (is_numeric($to_clean)) {
            if (is_string($to_clean)) {
                $to_clean = (float) $to_clean;
            }
            return \filter_var($to_clean, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        else{
            return FALSE;
        }
    }
        
    

    public function validate($to_validate) 
    {
        return \filter_var($to_validate, \FILTER_VALIDATE_FLOAT);
    }
    
    public function set_max_length($custom_max)
    {
        $this->max_length = $custom_max;
    }
}

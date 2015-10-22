<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\HTTP\Controllers\helpers\cleaning;

/**
 * Interface for all cleaners. This is the main security cleaning set of tools.
 * Everything should eventually be moved to this
 *
 * @author adam
 */
interface ICleaner 
{
    /**
     * This checks whether the input is a valid member of the type
     * @param type $to_validate
     * @param null $minLength
     * @param null $maxLength
     * @return Value or Boolean. Returns the thing passed in if it is valid. False otherwise
     */
    public function validate($to_validate, $minLength=null, $maxLength=null);

    /**
     * This cleans the input and returns a legitimate value or FALSE
     * @param type $to_clean
     * @param null $trimTo
     * @return
     */
    public function sanitize($to_clean, $trimTo=null);
    
    /**
     * Allows to set a custom max length for the thing being filtered and sanitized
     * @param type $custom_max
     */
    public function set_max_length($custom_max);
            
}

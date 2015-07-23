<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

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
     * @param $max_length
     * @return Value or Boolean. Returns the thing passed in if it is valid. False otherwise
     */
    public function validate($to_validate, $max_length=null);

    /**
     * This cleans the input and returns a legitimate value or throws
     * an exception if that's not possible
     * @param type $to_clean
     * @param $max_length
     * @return
     */
    public function sanitize($to_clean, $max_length=null);
    
    /**
     * Allows to set a custom max length for the thing being filtered and sanitized
     * @param type $custom_max
     */
    public function set_max_length($custom_max);
            
}

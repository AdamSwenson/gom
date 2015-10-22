<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\HTTP\Controllers\helpers\cleaning;

/**
 * Validates or sanitizes an integer value.
 * Works on numeric strings too.
 *
 * @author adam
 */
class IntegerCleaner implements ICleaner {

  //  const MAX_LENGTH = 100;

    protected $max_length;

    public function sanitize($to_clean, $trimTo=null)
    {
        //Not clear how trimTo would work

        if (is_numeric($to_clean)) {
            if (is_string($to_clean)) {
                $to_clean = (int) $to_clean;
            }
            return $to_clean;
        } else {
            return FALSE;
        }
    }

    /**
     * Works on numeric strings too
     * @param type $to_validate
     * @return type
     */
    public function validate($to_validate, $minLength=null, $maxLength=null)
    {
        //Check that longer than minimum
        if( !empty($minLength) && $to_validate < $minLength )
        {
            return false;
        }

        return filter_var($to_validate, FILTER_VALIDATE_INT);
    }

    public function set_max_length($custom_max) {
        $this->max_length = $custom_max;
    }

    public function trim() {
        if (!isset($this->max_length)) {
            $this->max_length = self::MAX_LENGTH;
        }
    }

}

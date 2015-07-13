<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

/**
 * Description of IntegerCleaner
 *
 * @author adam
 */
class IntegerCleaner implements ICleaner {

    const MAX_LENGTH = 100;

    protected $max_length;

    public function sanitize($to_clean) {
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
    public function validate($to_validate) {
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

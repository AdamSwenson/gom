<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

use \App\Exceptions\InputTypeException;

/**
 * Description of IntegerCleaner
 *
 * @author adam
 */
class IntegerCleaner implements ICleaner
{

    const MAX_LENGTH = 100;

    protected $max_length;

    /**
     * Cleans an integer or integer string. Returns the absolute value.
     *
     * If max_length is set, the value must be less than max_length.
     *
     *
     * @param type $to_clean
     * @param null $max_length
     * @return type|int
     * @throws InputTypeException
     */
    public function sanitize($to_clean, $max_length = null)
    {
        if (!is_numeric($to_clean))
        {
            throw new InputTypeException(InputTypeException::INTEGER_NON_NUMERIC);
        }
        if (is_string($to_clean))
        {
            $to_clean = (int)$to_clean;
        }
        $this->checkLength($to_clean, $max_length);

        $to_clean = abs($to_clean);

        return $to_clean;

    }

    protected function checkLength($to_clean, $max_length = null)
    {
        if (!empty($max_length) && ($to_clean > $max_length))
        {
            throw new InputTypeException(InputTypeException::INTEGER_TOO_LONG);
        }
    }


    /**
     * Works on numeric strings too
     * @param type $to_validate
     * @param $max_length
     * @return type
     */
    public function validate($to_validate, $max_length=null)
    {
        return filter_var($to_validate, FILTER_VALIDATE_INT);
    }

    public function set_max_length($custom_max)
    {
        $this->max_length = $custom_max;
    }

    public function trim()
    {
        if (!isset($this->max_length))
        {
            $this->max_length = self::MAX_LENGTH;
        }
    }

}

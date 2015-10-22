<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


namespace App\HTTP\Controllers\helpers\cleaning;
/**
 *
 * @author adam
 */
interface ICleanerFactory {

    /**
     * Runs the appropriate validation methods on the input.
     * If passes validation, returns the input.
     * If fails validation, returns false.
     *
     * @param $to_validate
     * @param $type
     * @param null $minLength
     * @param null $maxLength
     * @return mixed
     */
    public function validate($to_validate, $type, $minLength=null, $maxLength=null);
    
    
    public function sanitize($to_clean, $type);

}

<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

/**
 *
 * @author adam
 */
interface ICleanerFactory {
   
    public function validate($to_validate, $type);
    
    
    public function sanitize($to_clean, $type);

}

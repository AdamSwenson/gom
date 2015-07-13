<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\DirectOutputClassesencoders;

//use ezyang\htmlpurifier\HTMLPurifier_Config;
//    require_once '/path/to/HTMLPurifier.auto.php';
/**
 * Wrapper for handling filtering and purifying of html output 
 * 
 * @todo This has been removed for now until have a need for handling marked up input
 * When ready to use again, add this to the composer.json:
 * "ezyang/htmlpurifier": "*"
 * @author adam
 */
class HtmlEncoder
{
    public static $purifier;

protected function initialize()
{
    //if (!isset(self::$purifier)) {
 //   $config = \HTMLPurifier_Config::createDefault();
   // self::$purifier = new \HTMLPurifier($config);
    //}
}

public function clean($dirty_html)
{
    $this->initialize();
    //$clean_html = self::$purifier->purify($dirty_html);
return $dirty_html;
//    return $clean_html;
}

}

<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\DirectOutputClassescontrollers;

/**
 * This cleans and echoes a link to a page inside the gradeomatic for 
 * display to the user
 *
 * @author adam
 */
class InternalNavLink {
    /**
     * @param $label string to use as link label
     * @param $link string of link
     */
    public static function link($label, $link){
      echo "<a href='" . self::cleaner($link) . "'>" . self::cleaner($label) . "</a>";  
    }

    /**
     * Cleans the link
     * @param $to_clean
     * @return string
     */
    public static function cleaner($to_clean){
        return \htmlspecialchars($to_clean, \ENT_QUOTES, "UTF-8", "false");
    }

}

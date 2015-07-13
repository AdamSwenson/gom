<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 7:25 PM
 */

namespace App\classes\PreferenceClasses\service;


class SetPreferences
{

    /**
     * Checks whether preferences have been set in the session. If not
     * loads an object from the db and stores it in the session
     */
    static public function check_and_load()
    {
        if(isset($_SESSION)){
            if(!isset($_SESSION['preferences'])){
                $_SESSION['preferences'] = \App\classes\PreferenceClasses\dao\PreferencesDAO::load();
            }
        }
    }
}
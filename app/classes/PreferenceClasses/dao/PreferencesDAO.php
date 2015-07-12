<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 7:17 PM
 */

namespace PreferenceClasses\dao;


class PreferencesDAO
{

    /**
     * Loads a Preferences object into a session
     */
    static public function load()
    {
        return \PreferencesQuery::create()->find();
    }

    public function record($preferenceName, $newValue)
    {

    }
}
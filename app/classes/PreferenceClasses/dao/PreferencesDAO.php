<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 7:17 PM
 */

namespace App\classes\PreferenceClasses\dao;


use App\classes\Traits\UserTraits;

class PreferencesDAO
{

    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }
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
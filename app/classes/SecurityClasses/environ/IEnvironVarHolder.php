<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 9:24 AM
 */

namespace App\classes\SecurityClasses\environ;


interface IEnvironVarHolder 
{


    /**
     * Returns true if running on a local machine; false if running on the server
     */
    public function isLocal();

    /**
     * Returns true if running in a development environment (i.e., without actual paying users).
     * Throws exception if the environment wasn't explicitly set.
     */
    public function isDevelopment();

    /**
     * Returns true if running in test environment (e.g., unit test or jenkins)
     * @return bool
     */
    public function isTest();

    /**
     * @return string Returns path to vendor folder
     */
    public function getPathToVendor();

    /**
     * @return string Returns path to application root
     */
    public function getPathToRoot();


    /**
     * @return string Returns path to src folder (where the classes, etc are stored)
     */
    public function getPathToSrc();


    /**
     * @return string Either 'home' or 'remote'; if running on laptop, then home
     */
    public function getLocation();

    /**
     * @return string Either 'testing' or 'normal'. The former if doing unit tests or being run by jenkins
     */
    public function getRuntype();


    /**
     * @return string Either 'development' or 'live'. If the later, the system is being used by real users so do not fuck around
     */
    public function getDevstate();

}
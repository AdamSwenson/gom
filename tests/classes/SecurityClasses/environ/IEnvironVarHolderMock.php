<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 9:27 AM
 */

namespace SecurityClasses\environ;


class IEnvironVarHolderMock implements \SecurityClasses\environ\IEnvironVarHolder
{

    public $pathToVendor;

    public $pathToRoot;

    public $pathToLogRoot;

    public $pathToSrc;

    /** @var string Either 'home' or 'remote'; if running on laptop, then home */
    public $location;

    /** @var string  Either 'testing' or 'normal'. The former if doing unit tests or being run by jenkins */
    public $runtype;

    /** @var  string Either 'development' or 'live'. If the later, the system is being used by real users so do not fuck around */
    public $devstate;


    /**
     * @return string Returns path to vendor folder
     */
    public function getPathToVendor()
    {
        // TODO: Implement getPathToVendor() method.
    }

    /**
     * @return string Returns path to application root
     */
    public function getPathToRoot()
    {
        // TODO: Implement getPathToRoot() method.
    }

    /**
     * @return string Returns path to src folder (where the classes, etc are stored)
     */
    public function getPathToSrc()
    {
        // TODO: Implement getPathToSrc() method.
    }

    /**
     * @return string Either 'home' or 'remote'; if running on laptop, then home
     */
    public function getLocation()
    {
        // TODO: Implement getLocation() method.
    }

    /**
     * @return string Either 'testing' or 'normal'. The former if doing unit tests or being run by jenkins
     */
    public function getRuntype()
    {
        // TODO: Implement getRuntype() method.
    }

    /**
     * @return string Either 'development' or 'live'. If the later, the system is being used by real users so do not fuck around
     */
    public function getDevstate()
    {
        // TODO: Implement getDevstate() method.
    }

    /**
     * Returns true if running on a local machine; false if running on the server
     */
    public function isLocal()
    {
        // TODO: Implement isLocal() method.
    }

    /**
     * Returns true if running in a development environment (i.e., without actual paying users).
     * Throws exception if the environment wasn't explicitly set.
     */
    public function isDevelopment()
    {
        // TODO: Implement isDevelopment() method.
    }

    /**
     * Returns true if running in test environment (e.g., unit test or jenkins)
     * @return bool
     */
    public function isTest()
    {
        // TODO: Implement isTest() method.
    }
}
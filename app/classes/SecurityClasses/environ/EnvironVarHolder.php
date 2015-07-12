<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 8:52 AM
 */

namespace SecurityClasses\environ;

use SecurityClasses\errors\EnvironmentException;

/**
 * Class EnvironVarHolder
 * Singleton class which loads the environmental variables and
 * makes them available to other classes.
 *
 * Storing them in here so that it is easier to mock, test, etc
 *
 * This does NOT hold the gomUser credentials
 * This does NOT hold paths to logs.
 *
 * @package SecurityClasses\environ
 */
class EnvironVarHolder implements \SecurityClasses\environ\IEnvironVarHolder
{
    const RUNTYPE_TESTING = 'testing';
    const RUNTYPE_NORMAL = "normal";

    const DEVSTATE_DEVELOPMENT = 'development';
    const DEVSTATE_LIVE = 'live';

    /** var Running on local machine */
    const LOCATION_LOCAL = 'local';
    /** var running on server */
    const LOCATION_REMOTE = 'remote';

    //Names of the environmental variable
    const VARNAME_LOCATION = "LOCATION";
    const VARNAME_RUNTYPE = "RUNTYPE";
    const VARNAME_DEVSTATE = "DEVSTATE";

    const VARNAME_VENDOR_PATH = "APP_VENDOR_PATH";
    const VARNAME_ROOT_PATH = "APP_ROOT_PATH";
    const VARNAME_SRC_PATH = "APP_SRC_PATH";
    const VARNAME_PUBLIC_PATH = "APP_PUBLIC_PATH";

    /** @var array Array of strings comprising all environmental variable names used by this class */
    static public $vars = array(self::VARNAME_LOCATION, self::VARNAME_RUNTYPE, self::VARNAME_DEVSTATE,
        self::VARNAME_VENDOR_PATH, self::VARNAME_ROOT_PATH, self::VARNAME_SRC_PATH, self::VARNAME_PUBLIC_PATH );

    private static $instance;

    protected $pathToVendor;

    protected $pathToRoot;

    protected $pathToPublic;

    protected $pathToSrc;

    /** @var string Either 'home' or 'remote'; if running on laptop, then home */
    protected $location;

    /** @var string  Either 'testing' or 'normal'. The former if doing unit tests or being run by jenkins */
    protected $runtype;

    /** @var  string Either 'development' or 'live'. If the later, the system is being used by real users so do not fuck around */
    protected $devstate;


    private function __construct()
    {
        $this->location = getenv(self::VARNAME_LOCATION);
        $this->runtype = getenv(self::VARNAME_RUNTYPE);
        $this->devstate = getenv(self::VARNAME_DEVSTATE);

        $this->pathToVendor = getenv(self::VARNAME_VENDOR_PATH);
        $this->pathToRoot = getenv(self::VARNAME_ROOT_PATH);
        $this->pathToSrc = getenv(self::VARNAME_SRC_PATH);
        $this->pathToPublic = getenv(self::VARNAME_PUBLIC_PATH);
    }

    protected function checkSet($var, $errorType)
    {
        if (empty($var)) {
            throw new EnvironmentException($errorType);
        } else {
            return true;
        }
    }

    /**
     * Returns true if running in test environment (e.g., unit test or jenkins)
     * @return bool
     */
    public function isTest()
    {
        $this->checkSet($this->runtype, EnvironmentException::RUNSTATE);
        if ($this->runtype === self::RUNTYPE_TESTING) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns true if running in a development environment (i.e., without actual paying users).
     * Throws exception if the environment wasn't explicitly set.
     */
    public function isDevelopment()
    {
        $this->checkSet($this->devstate, EnvironmentException::DEVSTATE);
        if ($this->devstate === self::DEVSTATE_DEVELOPMENT) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns true if running on a local machine; false if running on the server
     */
    public function isLocal()
    {
        $this->checkSet($this->location, EnvironmentException::LOCATION);
        if ($this->location === self::LOCATION_LOCAL) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns false if running on a local machine; true if running on the server
     */
    public function isRemote()
    {
        $this->checkSet($this->location, EnvironmentException::LOCATION);
        if ($this->location === self::LOCATION_REMOTE) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getPathToVendor()
    {
        $this->checkSet($this->pathToVendor, EnvironmentException::PATH_VENDOR);
        return $this->pathToVendor;
    }

    /**
     * @return string
     */
    public function getPathToRoot()
    {
        $this->checkSet($this->pathToRoot, EnvironmentException::PATH_ROOT);
        return $this->pathToRoot;
    }

    /**
     * @return string
     */
    public function getPathToSrc()
    {
        $this->checkSet($this->pathToSrc, EnvironmentException::PATH_SRC);
        return $this->pathToSrc;
    }

    /**
     * @return mixed
     */
    public function getPathToPublic()
    {
        $this->checkSet($this->pathToPublic, EnvironmentException::PATH_PUBLIC);
        return $this->pathToPublic;
    }

    /**
     * @return string Either 'local' or 'remote'; if running on laptop, then local
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string Either 'testing' or 'normal'. The former if doing unit tests or being run by jenkins
     */
    public function getRuntype()
    {
        return $this->runtype;
    }

    /**
     * @return string Either 'development' or 'live'. If the later, the system is being used by real users so do not fuck around
     */
    public function getDevstate()
    {
        return $this->devstate;
    }

    public function __get($name)
    {
        if($this->$name){
            return $this->$name;
        }
    }

    /**
     * Undermine the whole point of a singleton. Used for testing only
     */
    public function destroy()
    {
        self::$instance = NULL;
    }

    /**
     * Use instead of constructor
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

}
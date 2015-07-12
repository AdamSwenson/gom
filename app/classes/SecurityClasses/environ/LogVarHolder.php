<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 9:13 AM
 */

namespace SecurityClasses\environ;

use SecurityClasses\errors\EnvironmentException;

/**
 * Class LogVarHolder
 * This gets and holds environmental variables related to logs
 * i.e., their names and paths
 *
 * @package SecurityClasses\environment
 */
class LogVarHolder 
{
    private static $instance;

    const ERROR_LOG_NAME = "errorlog";

    const USERS_QUERY_LOG_NAME = "querylog_users";

    const QUERY_LOG_NAME = "querylog_gom";

    //Names of environmental variables
    const VARNAME_ROOT_PATH = "APP_ROOT_PATH";
    const VARNAME_LOG_PATH = "APP_LOG_PATH";

    /** @var string Path to the application root folder */
    protected $pathToRoot;

    /** @var  string Path to the folder where all the logs are kept */
    protected $pathToLogRoot;

    /** @var  string Path to the html error log */
    protected $pathToErrorLog;


    /** @var  string Path to the html log of queries to the users table */
    protected $pathToUsersQueryLog;

    /** @var  string Path to the html log of queries to other schemas */
    protected $pathToQueryLog;

    /** @var array Array of strings comprising all environmental variable names used by this class */
    public static $vars = array(self::VARNAME_ROOT_PATH, self::VARNAME_LOG_PATH);

    public function __construct()
    {
        $this->pathToRoot = getenv(self::VARNAME_ROOT_PATH);
        $this->pathToLogRoot = getenv(self::VARNAME_LOG_PATH);
        if(!empty($this->pathToLogRoot))
        {
            $this->pathToQueryLog =  $this->pathToLogRoot . "/" . self::QUERY_LOG_NAME . ".html";
            $this->pathToUsersQueryLog = $this->pathToLogRoot . "/" . self::USERS_QUERY_LOG_NAME . ".html";
            $this->pathToErrorLog = $this->pathToLogRoot . "/" . self::ERROR_LOG_NAME . ".html";
        }
//        else{
//            throw new EnvironmentException(EnvironmentException::PATH_LOGROOT);
//        }
    }

    public function getErrorLogName()
    {
        return self::ERROR_LOG_NAME;
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
    public function getPathToLogRoot()
    {
        $this->checkSet($this->pathToLogRoot, EnvironmentException::PATH_LOGROOT);
        return $this->pathToLogRoot;
    }

    /**
     * @return string
     */
    public function getPathToErrorLog()
    {
        $this->checkSet($this->pathToErrorLog, EnvironmentException::PATH_ERRORLOG);
        return $this->pathToErrorLog;
    }

    /**
     * @return string
     */
    public function getPathToUsersQueryLog()
    {
        $this->checkSet($this->pathToUsersQueryLog, EnvironmentException::PATH_USERLOG);
        return $this->pathToUsersQueryLog;
    }

    /**
     * @return string
     */
    public function getUsersQueryLogName()
    {
        return self::USERS_QUERY_LOG_NAME;
    }

    /**
     * @return string
     */
    public function getPathToQueryLog()
    {
        $this->checkSet($this->pathToQueryLog, EnvironmentException::PATH_QUERYLOG);
        return $this->pathToQueryLog;
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
     * Use instead of constructor
     */
    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Undermine the whole point of a singleton. Used for testing only
     */
    public function destroy()
    {
        self::$instance = NULL;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 9:54 AM
 */

namespace SecurityClasses\errors;


class EnvironmentException extends \Exception
{

    const DEVSTATE = 100;
    const RUNSTATE = 101;
    const LOCATION = 102;

    const PATH_VENDOR = 200;
    const PATH_ROOT = 201;
    const PATH_SRC = 202;
    const PATH_PUBLIC = 203;

    const PATH_QUERYLOG = 300;
    const PATH_ERRORLOG = 301;
    const PATH_USERLOG = 302;
    const PATH_LOGROOT = 303;

    const PATH_TEMPLATES = 400;
    const PATH_CACHE = 401;

    public function __construct($errorType, $exception=null)
    {
        $message = $this->chooseMessage($errorType) . PHP_EOL;
        parent::__construct($message, null, $exception);
    }

    protected function chooseMessage($type)
    {
        switch($type)
        {
            case self::DEVSTATE:
                $message = "Devstate environmental variable not set";
                break;

            case self::RUNSTATE:
                $message = "RUNTYPE not set";
                break;
            case self::LOCATION:
                $message = "Location environmental variable not set";
                break;

            case self::PATH_VENDOR:
                $message = "Path to vendor folder not set";
                break;
            case self::PATH_ROOT:
                $message = "Path to application root not set";
                break;
            case self::PATH_SRC:
                $message = "Path to src folder not set";
                break;
            case self::PATH_PUBLIC:
                $message = "Path to public folder not set";
                break;

            case self::PATH_QUERYLOG:
                $message = "Path to query log not set";
                break;
            case self::PATH_ERRORLOG:
                $message = "Path to error log not set";
                break;
            case self::PATH_USERLOG:
                $message = "Path to users log not set";
                break;
            case self::PATH_LOGROOT:
                $message = "Path to log root folder not set";
                break;
            case self::PATH_TEMPLATES:
                $message = "Path to templates folder not set";
                break;
            case self::PATH_CACHE:
                $message = "Path to templates cache not set";
                break;
            default:
                $message = "Undefined environmental variable error ";
        }
        return $message;
    }
}
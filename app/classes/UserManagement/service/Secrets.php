<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 5:28 PM
 */

namespace App\classes\UserManagement\service;


class Secrets
{
    const TEST = 1;
    const NORMAL = 2;
    const USER = 3;

    /**
     * Normally this will detect the correct set of credentials
     * to run based on environmental variables. However, one of the
     * constants can be passed in to $type to override the environmental
     * variables. This is really only necessary in the special case of getting
     * user credentials
     * @param bool $type Not a boolean. Use one of the class constants
     * @param bool $userid
     * @return mixed
     * @throws \Exception
     */
    static public function factory($type = false, $userid = false)
    {
        if (!$type) { //no override; let the program choose on its own
            $instance = self::checkRuntype();
        } else { //override
            switch ($type) {
                case self::TEST:
                    $instance = self::load(self::TEST);
                    break;
                case self::NORMAL;
                    $instance = self::load(self::NORMAL);
                    break;
                case self::USER:
                    $instance = self::load(self::USER);
                    break;
                default:
                    throw new \Exception("Invalid override type requested");
            }
        }
        $instance->setLocation(self::determineLocation());
        $instance->setState(self::checkDevelopment());
        $instance->loadCredentials($userid);

        return $instance;
    }

    static function load($type)
    {
        switch ($type) {
            case self::TEST:
                return new TestingSecrets();
                break;
            case self::NORMAL:
                return new LiveSecrets();
                break;
            case self::USER:
                return new UserSecrets();
                break;
            default:
                throw new \Exception();
        }
    }


    /**
     * Checks whether the environmental variable is set and returns its
     * value. Throws exception otherwise.
     * @param string $environmentalVariable
     * @return string
     * @throws \Exception
     */
    static protected function check($environmentalVariable)
    {
        try {
            $env = getenv($environmentalVariable);
            if ((isset($env)) && (!empty($env))) {
                return $env;
            } else {
                throw new \Exception("Error checking environmental variable {$environmentalVariable}");
        }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Determines whether running on server or in local environment
     * @throws \Exception
     */
    static protected function determineLocation()
    {
        $env = self::check("LOCATION");
        switch ($env) {
            case 'local':
                return \UserManagement\service\SecretsParent::LOCATION_LOCAL;
                break;
            case 'remote':
                return \UserManagement\service\SecretsParent::LOCATION_REMOTE;
                break;
            default:
                throw new \Exception();
        }
    }

    /**
     * Detects whether in a testing or
     * @return string
     * @throws \Exception
     */
    static protected function checkRuntype()
    {
        $env = self::check("RUNTYPE");
        if ($env === 'testing')
        {
            return self::load(self::TEST);
        }
        else {
            return self::load(self::NORMAL);
        }
    }

    /**
     * Determines whether in a development environment or
     * a live environment (i.e., being used by actual folks)
     */
    static protected function checkDevelopment()
    {
        $env = self::check("DEVSTATE");
        switch($env)
        {
            case "development":
                return \UserManagement\service\SecretsParent::STATE_DEVELOPMENT;
                break;
            case "live":
                return \UserManagement\service\SecretsParent::STATE_LIVE;
                break;
            default:
                throw new \Exception();
        }
    }

//    public function __call($name, $args)
//    {
//        return self::$instance->$name($args);
//    }
}
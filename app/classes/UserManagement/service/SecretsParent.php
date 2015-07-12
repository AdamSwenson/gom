<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 5:41 PM
 */

namespace UserManagement\service;


abstract class SecretsParent implements ISecrets
{
    const LOCATION_LOCAL = 1;

    const LOCATION_REMOTE = 2;

    const STATE_DEVELOPMENT = 100;

    const STATE_LIVE = 101;

    protected $databasename;

    protected $dsn;

    /** @var  $host string Name of db host */
    protected $host;

    /** @var  $location string Whether running on in a local environment or on remote server */
    protected $location;

    protected $password;

    /** @var  $state string Whether running in a development state or live */
    protected $state;

    /** @var  $username string User name for db */
    protected $username;


    abstract public function loadCredentials($userid = false);

    protected function makeDsn()
    {
        $this->dsn = "mysql:host={$this->host};dbname={$this->databasename}";
    }

    /**
     * @param string $state
     * @throws \Exception
     */
    public function setState($state)
    {
        switch($state)
        {
            case self::STATE_DEVELOPMENT:
                $this->state = self::STATE_DEVELOPMENT;
                break;
            case self::STATE_LIVE:
                $this->state = self::STATE_LIVE;
                break;
            default:
                throw new \Exception();
        }
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getDatabasename()
    {
        return $this->databasename;
    }

    /**
     * @param mixed $databasename
     */
    public function setDatabasename($databasename)
    {
        $this->databasename = $databasename;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDsn()
    {
        if(empty($this->dsn))
        {
            $this->makeDsn();
        }
        return $this->dsn;
    }

    /**
     * @param mixed $dsn
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

}
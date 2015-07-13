<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 5:29 PM
 */

namespace UserManagement\service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class LiveSecrets
 * Queries the users database to get a particular user's credentials
 * then stores them.
 * @package UserManagement\service
 */
class LiveSecrets extends SecretsParent
{

    static protected $log;

    /** @var  $pdo \PDO Connection to database */
    static protected $pdo;

    /** @var  \UserManagement\service\UserSecrets */
    protected $userDbCredentials;

    protected $logVariables;


    public function loadCredentials($userid = false)
    {
        if (empty(self::$pdo)) {
            $this->userDbCredentials = \UserManagement\service\Secrets::factory(\UserManagement\service\Secrets::USER);
            $this->createConnection();
        }
        unset($this->userDbCredentials);
        $this->getUserCredentials($userid);
        $this->makeDsn();
    }

    /**
     * Handles retrieving the credentials for a user's own db
     * TODO: Fix the procedure so can be called by non-root
     * @param $userid int Id of user to retrieve credentials for
     * @throws \Exception
     */
    protected function getUserCredentials($userid)
    {
        try{
            if(!isset($userid) || empty($userid) || !is_integer($userid)){
                throw new \Exception("Invalid userid passed in : $userid");
            }
//            $query = "CALL get_user_database_credentials(:userid)";
            $query = "SELECT db_name, db_username, db_password FROM user_databases WHERE userID = :userid";
            $vals = array('userid' => $userid);
            try {
                self::$log->addInfo("Query: " . $query . " For id: " . $userid);
                $stmt = self::$pdo->prepare($query);
                $stmt->execute($vals);
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $resultAssoc = $stmt->fetch();

                $this->databasename = $resultAssoc['db_name'];
                $this->password = $resultAssoc['db_password'];
                $this->username = $resultAssoc['db_username'];
            } catch (\PDOException $e) {
                throw new \Exception(__CLASS__ . ':<br/> Execute failed: ' . $e->getMessage());
            } finally {
                if (!empty($stmt)) {
                    $stmt->closeCursor();
                }
            }
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Creates a pdo connection to the gradeomaticUSERS database
     * @throws \Exception
     */
    protected function createConnection()
    {
        try {
            $this->initialize_logger();
            self::$pdo = new \PDO($this->userDbCredentials->getDsn(),
                $this->userDbCredentials->getUsername(),
                $this->userDbCredentials->getPassword(),
                array(\PDO::ATTR_PERSISTENT => true)
            );
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ISSUES STANDARD PHP WARNING
            self::$log->addInfo("Users database connection created");
        } catch (\PDOException $e) {
            if(!empty(self::$log)){
                self::$log->addInfo("<br/> Users database connection failed " . $e->getMessage());
            }
            throw new \Exception('<br/> Connection failed: ' . $e->getMessage());
        }
    }

    public function loadLogVariables()
    {
        try{
            $this->logVariables = \App\classes\SecurityClasses\environ\LogVarHolder::getInstance();
        }catch(\Exception $e)
        {
            error_log("Could not load log variables object " . $e);
        }
    }

    /**
     * This creates the logger object if not already set.
     * Stores exception to error log, but should not take everything down
     */
    public function initialize_logger()
    {
        $this->loadLogVariables();
        if (!empty($this->logVariables)) {
            try {
                if (empty(self::$log)) {
                    $formatter = new \Monolog\Formatter\HtmlFormatter();
                    self::$log = new Logger($this->logVariables->getUsersQueryLogName());
                    $stream = new StreamHandler($this->logVariables->getPathToUsersQueryLog(), Logger::INFO);
                    $stream->setFormatter($formatter);
                    self::$log->pushHandler($stream);
                    self::$log->addInfo("Logger initialized");
                }
            } catch (\Exception $e) {
                error_log("Failed to initialize logger for users query log" . PHP_EOL . " " . $e);
            }
        }
    }

}


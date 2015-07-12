<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/15
 * Time: 3:25 PM
 */

namespace UserManagement\dao;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use SecurityClasses\environ\LogVarHolder;
use UserManagement\errors\NewDbSetupException;
use UserManagement\service\UserSecrets;

class UsersDbConnection
{
    static protected $pdo;

    static protected $log;

    static private $gom_users_dsn = "mysql:host=localhost;dbname=gradeomaticUsers";
    static private $username;
    static private $password;

    public function __construct()
    {
        if (empty(self::$username) || empty(self::$password)) {
            $credentials = new UserSecrets();
            self::$username = $credentials->getUsername();
            self::$password = $credentials->getPassword();
        }
        $this->createConnection();
    }

    static protected function handle_exception($exception)
    {
        //  self::$log->addError($exception->getMessage());
        throw new \Exception($exception);
    }


    /**
     * Creates a pdo connection to the gradeomaticUSERS database
     * @throws \Exception
     */
    protected function createConnection()
    {
        try {
            $this->initialize_logger();
            if (empty(self::$pdo)) {
                self::$pdo = new \PDO(
                    self::$gom_users_dsn,
                    self::$username,
                    self::$password,
                    array(\PDO::ATTR_PERSISTENT => true)
                );
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ISSUES STANDARD PHP WARNING
                self::$log->addInfo("New gom_users database connection created");
            }
        } catch (\PDOException $e) {
            if (!empty(self::$log)) {
           //     self::$log->addInfo(NewDbSetupException::CONNECTION_FAIL_GOM_USERS . $e->getMessage());
            }
            throw new NewDbSetupException(NewDbSetupException::CONNECTION_FAIL_GOM_USERS . $e->getMessage());
        }
    }

    /**
     * This creates the logger object if not already set.
     * Stores exception to error log, but should not take everything down
     */
    public function initialize_logger()
    {
        try {
            if (empty(self::$log)) {
                $log_vars = LogVarHolder::getInstance();
                if($log_vars)
                {
                    $formatter = new \Monolog\Formatter\HtmlFormatter();
                    self::$log = new Logger($log_vars->getUsersQueryLogName());
                    $stream = new StreamHandler($log_vars->getPathToUsersQueryLog(), Logger::INFO);
                    $stream->setFormatter($formatter);
                    self::$log->pushHandler($stream);
                    self::$log->addInfo("Logger initialized");
                }
            }
        } catch (\Exception $e) {
            error_log("Failed to initialize logger for " . LogVarHolder::USERS_QUERY_LOG_NAME . PHP_EOL . $e);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 3:16 PM
 */

namespace UserManagement\dao;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use UserManagement\errors\NewDbSetupException;

class UserTableManagementDao extends UsersDbConnection implements \UserManagement\dao\IUserTableManagmentDao
{

    static protected $root;

    /** @var  $pdo \PDO Connection to database */
    static protected $pdo;

    protected $user;

    public function __construct()
    {
        if (empty(self::$root)) {
            self::$root = getenv("APP_ROOT_PATH");
        }
        parent::__construct();
        if (empty(self::$pdo)) {
            self::$pdo = parent::$pdo;
        }
    }

    public function make($user)
    {
        $this->user = $user;
//        $this->createConnection();
        self::$pdo->beginTransaction();
        try {
            try {
                $this->insert_credentials_into_users();
                self::$pdo->commit();
                return true;
            } catch (\PDOException $e) {
                self::$pdo->rollBack();
             //   parent::$log->addError("Transaction failed. Rolling back. " . $e);
                throw $e;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function insert_credentials_into_users()
    {
        try {
            $db_name = $this->user->get_db_name();
            $userid = $this->user->displayID();
            $username = $this->user->get_db_username();
            $password = $this->user->get_db_password();
            $created_date = date("Y-m-d H:i:s");

            $query = <<<Q
    INSERT INTO user_databases (db_name, userID, db_username, db_password, ro_username, ro_password, createdOn)
    VALUES (:db_name, :userID, :username, :password, :username, :password, :created)
    ON DUPLICATE KEY UPDATE db_username = :username, db_password = :password, ro_username = :username, ro_password = :password
Q;
            //$query = "CALL insert_user_database((:db_name, :username, :password, :username, :password)";
//            self::$log->addInfo($query);
            $stmt = self::$pdo->prepare($query);
//        $stmt = self::$pdo->prepare("CALL add_user(:db_name, :username, :password, :username, :password)");
            $stmt->bindParam(":db_name", $db_name);
            $stmt->bindParam(":userID", $userid);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":created", $created_date);

//        $query = "CALL add_user({$user->getDatabasename()}, {$user->getUsername()}, {$user->getPassword()}, {$user->getUsername()}, {$user->getPassword()})";
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_SAVE_CREDENTIALS, $e);
        }
    }

    static protected function handle_exception($exception)
    {
        //  self::$log->addError($exception->getMessage());
        throw new \Exception($exception);
    }

    /**
     * This retrieves the userID for the newly activated account from the activation token. It loads the user id for use in the next steps.
     * @param  string $token The activation token sent via email
     * @throws \Exception
     */
    public function retrieve_userid_from_token($token)
    {
        try {
            try {
                $query = "SELECT id FROM uc_users WHERE activation_token = :token";
//                parent::$log->addInfo($query . ' for: ' . $token);
                $stmt = self::$pdo->prepare($query);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $resultAssoc = $stmt->fetch();
                if (isset($resultAssoc['id'])) {
                    $userID = $resultAssoc['id'];
                    return $userID;
                } else {
                    throw new NewDbSetupException(NewDbSetupException::TOKEN_RETRIEVAL);
                }
            } catch (\PDOException $e) {
                new NewDbSetupException(NewDbSetupException::TOKEN_RETRIEVAL, $e);
//                self::handle_exception($e);
            }
        } catch (\Exception $e) {
            throw new NewDbSetupException(NewDbSetupException::CONNECTION_FAIL_NEW_DB, $e);
        }
    }

//
//    /**
//     * Creates a pdo connection to the gradeomaticUSERS database
//     * @throws \Exception
//     */
//    protected function createConnection()
//    {
////        $this->userDbCredentials->getDsn(),
////                    $this->userDbCredentials->getUsername(),
////                    $this->userDbCredentials->getPassword(),
//        try {
//            $this->initialize_logger();
//            if (empty(self::$pdo)) {
//                self::$pdo = new \PDO(
//                    "mysql:host=localhost;dbname=gradeomaticUSERS",
//                    "root",
//                    "",
//                    array(\PDO::ATTR_PERSISTENT => true)
//                );
//                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ISSUES STANDARD PHP WARNING
//                self::$log->addInfo("Users database connection created");
//            }
//        } catch (\PDOException $e) {
//            if (!empty(self::$log)) {
//                self::$log->addInfo("<br/> Users database connection failed " . $e->getMessage());
//            }
//            throw new \Exception('<br/> Connection failed: ' . $e->getMessage());
//        }
//    }

//    /**
//     * This creates the logger object if not already set.
//     * Stores exception to error log, but should not take everything down
//     */
//    public function initialize_logger()
//    {
//        try {
//            if (empty(self::$log)) {
//                $formatter = new \Monolog\Formatter\HtmlFormatter();
//                self::$log = new Logger(self::$logName);
//                $stream = new StreamHandler(self::$root . "/log/" . self::$logName, Logger::INFO);
//                $stream->setFormatter($formatter);
//                self::$log->pushHandler($stream);
//                self::$log->addInfo("Logger initialized");
//            }
//        } catch (\Exception $e) {
//            error_log("Failed to initialize logger for " . self::$logName . " \n" . $e);
//        }
//    }
//

}
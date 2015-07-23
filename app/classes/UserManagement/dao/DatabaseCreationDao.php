<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/15
 * Time: 3:17 PM
 */

namespace App\classes\UserManagement\dao;


use App\classes\UserManagement\errors\NewDbSetupException;

class DatabaseCreationDao extends App\classes\UserManagement\dao\UsersDbConnection
{
    static protected $users_db_pdo;

    protected $new_db_pdo;

    static protected $logName = "user_setup_log.html";

    static protected $root;

    protected $user;

    public function __construct()
    {
        if (empty(self::$root)) {
            self::$root = getenv("APP_ROOT_PATH");
        }
        parent::__construct();

        if (empty(self::$users_db_pdo)) {
            self::$users_db_pdo = parent::$pdo;
        }
    }

    /**
     * The main publicly called method which handles all operations for making the user schema
     * @param $user
     * @return bool
     * @throws NewDbSetupException
     */
    public function make($user)
    {
        $this->user = $user;
        try{
            $this->user_db_operations();
            $this->new_db_operations();
            return true;
        }catch(NewDbSetupException $e)
        {
            throw $e;
        }
        catch (\Exception $e) {
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_MAKE, $e);
        }
    }

    /**
     * Handles creating the new schema and granting the new user access to
     * the schema
     * @return bool
     * @throws \Exception
     */
    public function user_db_operations()
    {
        try {
            self::$users_db_pdo->beginTransaction();
            $this->create_database();
            $this->grant_user_access();
            self::$users_db_pdo->commit();
            return true;
        }
        catch(NewDbSetupException $e)
        {
            self::$users_db_pdo->rollBack();
            //parent::$log->addError("Transaction failed. Rolling back. " . $e);
            throw $e;
        }
        catch (\Exception $e) {
            self::$users_db_pdo->rollBack();
          //  parent::$log->addError("Transaction failed. Rolling back. " . $e);
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_USERDB, $e);
        }
    }

    public function new_db_operations()
    {
        try {
            $this->createConnectionToNewDb();
            $this->new_db_pdo->beginTransaction();
            $this->populate_tables();
            $this->new_db_pdo->commit();
            return true;
        } catch (\PDOException $e) {
            $this->new_db_pdo->rollBack();
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_NEWDB, $e);
        }
    }

    public function create_database()
    {
        try {
            $query = "CREATE database {$this->user->get_db_name()}";
            $stmt = self::$users_db_pdo->prepare($query);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_CREATE, $e);
        }
    }

    public function grant_user_access()
    {
        $host = 'localhost';
        $db_name = $this->user->get_db_name();
        $username = $this->user->get_db_username();
        $password = $this->user->get_db_password();

        $query = "GRANT SELECT, INSERT, UPDATE, EXECUTE, DELETE ON {$db_name}.*
        TO '{$username}'@'{$host}' IDENTIFIED BY '{$password}'";

        try {
            $stmt = self::$users_db_pdo->prepare($query);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_GRANT, $e);
//            parent::handle_exception($e);
        }
    }

    /**
     * Reads sql dump files and populates the schema with tables.
     * TODO: Integrate this with Propel
     * @return bool
     * @throws \Exception
     */
    public function populate_tables()
    {
        try {
            $sql_file = self::$root . "/src/lib/generated-sql/gom.sql";
            $contents = file_get_contents($sql_file);

            // Remove C style and inline comments
            $comment_patterns = array(
                '/\/\*.*(\n)*.*(\*\/)?/', //C comments
                '/\s*--.*\n/', //inline comments start with --
                '/\s*#.*\n/', //inline comments start with #
            );
            $contents = preg_replace($comment_patterns, "\n", $contents);

            //Retrieve sql statements
            $statements = explode(";\n", $contents);
            $statements = preg_replace("/\s/", ' ', $statements);

            foreach ($statements as $query) {
                if (trim($query) != '') {
                    echo 'Executing query: ' . $query . "<br/>\n";
                    $this->new_db_pdo->exec($query);
                    echo "<br/>Executed";
                }
            }
            return true;
        } catch (\PDOException $e) {
            throw new NewDbSetupException(NewDbSetupException::OPERATIONS_FAIL_POPULATE, $e);
        }
    }


    /**
     * Creates a pdo connection to the newly created database
     * @throws \Exception
     */
    public function createConnectionToNewDb()
    {
        try {
            $this->new_db_pdo = new \PDO(
                "mysql:host=localhost;dbname={$this->user->get_db_name()}",
                $this->user->get_db_username(),
                $this->user->get_db_password(),
                array(\PDO::ATTR_PERSISTENT => true)
            );
            $this->new_db_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ISSUES STANDARD PHP WARNING
         //   parent::$log->addInfo("Connection to the newly created database created");

        } catch (\PDOException $e) {
            if (!empty(parent::$log)) {
//                parent::$log->addInfo(NewDbSetupException::CONNECTION_FAIL_NEW_DB . $e->getMessage());
            }
            throw new NewDbSetupException(NewDbSetupException::CONNECTION_FAIL_NEW_DB, $e);
        }
    }

}
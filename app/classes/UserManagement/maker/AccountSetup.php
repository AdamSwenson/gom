<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\Classes\UserManagement\maker;

use App\Classes\UserManagement\dao\IDatabaseCreationDao;
use App\Classes\UserManagement\dao\IUserTableManagementDao;
use App\Classes\UserManagement\errors\NewDbSetupException;
use App\Classes\UserManagement\maker\ICredentialGenerator;
use App\Classes\UserManagement\maker\ISetupWatcher;
use App\Classes\UserManagement\maker\SetupWatcher;
use App\Classes\UserManagement\models\SettableUser;

/**
 * This is the master controller for creating a new user and their schema.
 * It executes all the calls for setting up the new user and their schema.
 * It is run after the user responds to the activation emails
 *
 * @author adam
 */
class AccountSetup
{
    /** @var  ISetupWatcher */
    public $watcher;

    /** @var $database_creation_service \App\Classes\UserManagement\maker\IDatabaseGenerator Service object which handles db creation */
    public $database_creation_service;

    /** @var $user_creation_service \App\Classes\UserManagement\maker\IUserMaker */
    public $user_creation_service;

    public $credential_generator;

    /** @var $user_table_dao \App\Classes\UserManagement\dao\IUserTableManagementDao Handles interaction with the gradeomaticUSERS */
    protected $user_table_dao;

    /** @var $user \App\Classes\UserManagement\models\ISettableUser */
    public $user;

    /** @var  IDatabaseCreationDao */
    protected $new_db_dao;

    /**
     * Loads the object which interacts with the gradeomaticUSERS table
     * @param \App\classes\UserManagement\dao|IUserTableManagementDao $user_table_dao
     */
    public function set_user_table_access(IUserTableManagementDao $user_table_dao)
    {
        $this->user_table_dao = $user_table_dao;
    }

    /**
     * Loads the object which will interact with the newly created schema
     * @param IDatabaseCreationDao $new_db_dao
     */
    public function setNewDbDao(IDatabaseCreationDao $new_db_dao)
    {
        $this->new_db_dao = $new_db_dao;
    }

    /**
     * Loads the object which will create credentials for the new user
     *
     * Before passing in, should do:
     * $watcher = new SetupWatcher();
     * $watcher->attach(new UserNotifier());
     * $watcher->attach(new UserSetupLogger());
     *
     * @param ICredentialGenerator $credential_generator
     */
    public function set_credential_generator(ICredentialGenerator $credential_generator)
    {
        $this->credential_generator = $credential_generator;
    }

    /**
     * Attaches the object that will handle logging and user notification.
     * @param ISetupWatcher $watcher
     */
    public function setWatcher(ISetupWatcher $watcher)
    {
        $this->watcher = $watcher;
    }

    /**
     * Runs the account setup process
     * TODO Check length for expected size
     * @param string $token Hash sent to registrant's emails
     * @return bool
     * @throws \Exception
     */
    public function run($token)
    {
        try {
            $this->lookupUser($token);
            $this->makeCredentials();
            if ($this->check_user_credentials_set()) {
                if ($this->user_table_dao->make($this->user)) {
                    $this->new_db_dao->make($this->user);
                    $this->watcher->update(SetupWatcher::GOM_USER_COMPLETE);
                }
            }
        }
        catch(NewDbSetupException $e)
        {
            $this->watcher->handleException($e);
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }


    /**
     * Generates db credentials for the user and adds them to the user object
     * @throws \Exception
     */
    public function makeCredentials()
    {
        try {
            if ($this->check_userid_set()) {
                $this->user->set_db_username($this->credential_generator->make_username());
                $this->user->set_db_password($this->credential_generator->make_password());
                $this->user->set_ro_username($this->credential_generator->make_username());
                $this->user->set_ro_password($this->credential_generator->make_password());
                $this->user->set_db_name($this->credential_generator->make_db_name($this->user->displayID()));
            } else {
                throw new NewDbSetupException(NewDbSetupException::USER_CREDENTIALS_SET);
            }
        }
        catch(NewDbSetupException $e)
        {
            $this->watcher->handleException($e);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Runs the part of the creation procedure which creates
     * (1) Registers a user in gradeomatic users
     * (2) Creates credentials for user to access their database schema (which is not created by this)
     * (3) Loads the credentials into a user object to be passed to other functions
     *
     * @param string $token Activation token emailed to new registrant
     * @return \App\Classes\UserManagement\models\ISettableUser A user object loaded with db credentials
     * @throws \Exception
     */
    public function lookupUser($token)
    {
        try {
            //Lookup user id and create and set user
            $userid = $this->user_table_dao->retrieve_userid_from_token($token);
            $this->user = new SettableUser();
            $this->user->set_id($userid);
        }
        catch(NewDbSetupException $e)
        {
            $this->watcher->handleException($e);
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

    protected function check_userid_set()
    {
        if (!empty($this->user->displayID())) {
            $this->watcher->update(SetupWatcher::USER_RECORD_FOUND);
            return true;
        } else {
            $this->watcher->update(SetupWatcher::USER_RECORD_NOT_FOUND);
            return false;
        }
    }

    protected function check_user_credentials_set()
    {
        if ($this->user->check_loaded()) //        if(!empty($this->user->get_db_name()) && !empty($this->user->get_db_username()) && !empty($this->user->get_db_password()))
        {
            $this->watcher->update(SetupWatcher::DB_CREDENTIALS_CREATED);
            return true;
        } else {
            return false;
        }
    }


}

<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace UserManagement\maker;

use UserManagement\dao\IUserTableManagmentDao;
use UserManagement\errors\NewDbSetupException;

/**
 * This is the master controller for creating a new user and their schema.
 * It executes all the calls for setting up the new user and their schema.
 * It is run after the user responds to the activation email
 *
 * @author adam
 */
class AccountSetup
{
    /** @var  \UserManagement\maker\ISetupWatcher */
    public $watcher;

    /** @var $database_creation_service \UserManagement\maker\IDatabaseGenerator Service object which handles db creation */
    public $database_creation_service;

    /** @var $user_creation_service \UserManagement\maker\IUserMaker */
    public $user_creation_service;

    public $credential_generator;

    /** @var $user_table_dao \UserManagement\dao\IUserTableManagementDao Handles interaction with the gradeomaticUSERS */
    protected $user_table_dao;

    /** @var $user \UserManagement\models\ISettableUser */
    public $user;

    /** @var  \UserManagement\dao\IDatabaseCreationDao */
    protected $new_db_dao;

    /**
     * Loads the object which interacts with the gradeomaticUSERS table
     * @param \UserManagement\dao\IUserTableManagementDao|IUserTableManagmentDao $user_table_dao
     */
    public function set_user_table_access(IUserTableManagmentDao $user_table_dao)
    {
        $this->user_table_dao = $user_table_dao;
    }

    /**
     * Loads the object which will interact with the newly created schema
     * @param \UserManagement\dao\IDatabaseCreationDao $new_db_dao
     */
    public function setNewDbDao(\UserManagement\dao\IDatabaseCreationDao $new_db_dao)
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
     * @param \UserManagement\maker\ICredentialGenerator $credential_generator
     */
    public function set_credential_generator(\UserManagement\maker\ICredentialGenerator $credential_generator)
    {
        $this->credential_generator = $credential_generator;
    }

    /**
     * Attaches the object that will handle logging and user notification.
     * @param \UserManagement\maker\ISetupWatcher $watcher
     */
    public function setWatcher(\UserManagement\maker\ISetupWatcher $watcher)
    {
        $this->watcher = $watcher;
    }

    /**
     * Runs the account setup process
     * TODO Check length for expected size
     * @param string $token Hash sent to registrant's email
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
                    $this->watcher->update(\UserManagement\maker\SetupWatcher::GOM_USER_COMPLETE);
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
     * @return \UserManagement\models\ISettableUser A user object loaded with db credentials
     * @throws \Exception
     */
    public function lookupUser($token)
    {
        try {
            //Lookup user id and create and set user
            $userid = $this->user_table_dao->retrieve_userid_from_token($token);
            $this->user = new \UserManagement\models\SettableUser();
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
            $this->watcher->update(\UserManagement\maker\SetupWatcher::USER_RECORD_FOUND);
            return true;
        } else {
            $this->watcher->update(\UserManagement\maker\SetupWatcher::USER_RECORD_NOT_FOUND);
            return false;
        }
    }

    protected function check_user_credentials_set()
    {
        if ($this->user->check_loaded()) //        if(!empty($this->user->get_db_name()) && !empty($this->user->get_db_username()) && !empty($this->user->get_db_password()))
        {
            $this->watcher->update(\UserManagement\maker\SetupWatcher::DB_CREDENTIALS_CREATED);
            return true;
        } else {
            return false;
        }
    }


}

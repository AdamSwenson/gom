<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\UserManagement\maker;

/**
 * Description of IDatabasePolicyMock
 *
 * @author adam
 */
class IDatabaseGeneratorMock implements IDatabaseCreationService {
    /** @var $db_creation_dao \App\classes\UserManagement\dao\IDatabaseManagementDao Creates and sets up a new schema for user */
    public $db_creation_dao;

    public $response;
    
    /** @var $user_table_dao \App\classes\UserManagement\dao\IUserTableManagementDao Handles interaction with the gradeomaticUSERS */
    protected $user_table_dao;

    public function set_response($response) {
        $this->response = $response;
    }

    public function create_database(\App\classes\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_handlers(\App\classes\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_procedures(\App\classes\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_tables(\App\classes\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function register_user_schema(\App\classes\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function set_dataservice(\App\classes\UserManagement\dao\IDatabaseCreationDao $db_management_dao) {
        return $this->response;
    }

    public function set_user_table_service(\App\classes\UserManagement\dao\IUserTableManagementDao $user_table_dao) {
        return $this->response;
    }

    public function update_dao_connection(\Interfaces\IDataAccessObject $dao) {
        $this->db_creation_dao = $dao;
        return $this->response;
    }

}

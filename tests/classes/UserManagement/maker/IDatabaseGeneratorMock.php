<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace UserManagement\maker;

/**
 * Description of IDatabasePolicyMock
 *
 * @author adam
 */
class IDatabaseGeneratorMock implements IDatabaseCreationService {
    /** @var $db_creation_dao \UserManagement\dao\IDatabaseManagementDao Creates and sets up a new schema for user */
    public $db_creation_dao;

    public $response;
    
    /** @var $user_table_dao \UserManagement\dao\IUserTableManagementDao Handles interaction with the gradeomaticUSERS */
    protected $user_table_dao;

    public function set_response($response) {
        $this->response = $response;
    }

    public function create_database(\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_handlers(\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_procedures(\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function create_tables(\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function register_user_schema(\UserManagement\models\ISettableUser $user) {
        return $this->response;
    }

    public function set_dataservice(\UserManagement\dao\IDatabaseCreationDao $db_management_dao) {
        return $this->response;
    }

    public function set_user_table_service(\UserManagement\dao\IUserTableManagementDao $user_table_dao) {
        return $this->response;
    }

    public function update_dao_connection(\Interfaces\IDataAccessObject $dao) {
        $this->db_creation_dao = $dao;
        return $this->response;
    }

}

<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\UserManagement\maker;

/**
 * Description of IUserMakerMock
 *
 * @author adam
 */
class IUserMakerMock implements IUserMaker
{
    public function set_response($response)
    {
        $this->response = $response;

    }
    public function create_credentials(\App\classes\UserManagement\models\ISettableUser $user)
    {
        return $this->response;
    }

    public function load_user($token)
    {
        return $this->response;
    }

    public function make_user($token)
    {
        return $this->response;
    }

    public function retrieve_credentials(\App\classes\UserManagement\models\ISettableUser $user)
    {
        return $this->response;
    }

    public function set_credential_generator(ICredentialGenerator $credential_generator)
    {
        return $this->response;
    }

    public function set_logger($logger)
    {
        return $this->response;
    }

    public function set_user_table_service(\App\classes\UserManagement\dao\IUserTableManagementDao $user_table_dao)
    {
        return $this->response;
    }

    public function set_user_access($user)
    {
        return $this->response;
    }
}

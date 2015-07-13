<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace UserManagement\maker;

use classes\MockParent;

/**
 * Description of ICredentialGeneratorMock
 *
 * @author adam
 */
class ICredentialGeneratorMock extends MockParent implements ICredentialGenerator
{
    public $db_name;
    public $password;
    public $username;

    public function make_db_name($databaseID)
    {
        $this->record_call(__FUNCTION__, array($databaseID));
        return $this->db_name;
    }

    public function make_password()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->password;
    }

    public function make_username()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->username;
    }

}

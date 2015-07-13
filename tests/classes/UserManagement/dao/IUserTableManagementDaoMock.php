<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/15/15
 * Time: 2:01 PM
 */

namespace UserManagement\dao;


class IUserTableManagementDaoMock extends \classes\MockParent implements \UserManagement\dao\IUserTableManagmentDao
{

    public function make($user)
    {
        $this->record_call(__FUNCTION__, array($user));
        return $this->response;
    }

    /**
     * This retrieves the userID for the newly activated account from the activation token. It loads the user id for use in the next steps.
     * @param  string $token The activation token sent via email
     * @throws \Exception
     */
    public function retrieve_userid_from_token($token)
    {
        $this->record_call(__FUNCTION__, array($token));
        return $this->response;
    }
}
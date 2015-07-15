<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 3:16 PM
 */

namespace App\classes\UserManagement\dao;


interface IUserTableManagementDao
{


    public function make($user);
  //public function create_database_for_new_user(\UserManagement\models\ISettableUser $user);
        /**
         * This retrieves the userID for the newly activated account from the activation token. It loads the user id for use in the next steps.
         * @param  string $token The activation token sent via email
         * @throws \Exception
         */
        public function retrieve_userid_from_token($token);
}
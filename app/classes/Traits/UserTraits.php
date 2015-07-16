<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 10:56 AM
 */

namespace App\classes\Traits;
use App\User;
use Auth;
/**
 * Class UserTraits
 * These are tools for using laravel's authentication process
 * @package classes\Traits
 */
trait UserTraits
{

    /**
     * Returns true if the user is logged in; false otherwise
     * @return mixed
     */
    public function isLoggedIn()
    {
        return Auth::check();
    }

    /**
     * Returns a propel User
     * @return bool
     */
    public function getUser()
    {
        if (Auth::check()) {
//            $user = Auth::user();
            $user = \UserQuery::create()->filterById(Auth::id())->findOne();
            return $user;
        }else{
            return false;
        }
    }

    /**
     * Returns the users id
     * @return mixed
     */
    public function getId()
    {
        return Auth::id();
    }
}
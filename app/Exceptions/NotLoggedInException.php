<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/4/15
 * Time: 3:25 PM
 */

namespace Exceptions;

/**
 * Class NotLoggedInException
 *
 * Thrown if the user is not logged in or if their session has been expired.
 * Redirects to the login page
 *
 * @package Exceptions
 */
class NotLoggedInException extends \Exception
{

    /**
     * @param null $type One of the constants to determine exception type
     * @param null $exception A previously caught exception
     */
    public function __construct($type=null, $exception=null)
    {
     return view('auth.login');
    }


}
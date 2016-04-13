<?php
namespace Page;

class LoginPage
{
    public static $testAccountEmail = 'test2@gradeomatic.net';
    public static $testAccountPassword = "testtest";

    // include url of current page
    public static $URL = '/auth/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $emailField = '//*[@id="email"]';
    public static $passwordField = '//*[@id="password"]';
    public static $rememberField = '#remember';

    public static $forgotPasswordRoute = '/password/email';

    public static $loginButton = '#login';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }


}

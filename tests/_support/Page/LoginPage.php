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

    public static $rememberCheckLocator = ['id' => 'remember'];

    public static $pageHeadingText = "Login";
    public static $pageTitleText = "Login | gradeomatic";
    
    
    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    public static function assertPageIntact($I){
     
            $I->amGoingTo("Visit the login page");

            $I->expectTo("see the various elements of the lgoin page");
            $I->seeElement(LoginPage::$emailField);
            $I->seeElement(LoginPage::$passwordField);
            $I->seeElement(LoginPage::$loginButton);

            $I->see(LoginPage::$pageHeadingText);
            $I->seeInTitle(LoginPage::$pageTitleText);
            $I->seeInCurrentUrl(LoginPage::$URL);

            $I->seeElement(['id' => 'remember']);
            $I->see("Remember me");
            $I->seeLink("Forgot Password", url('') . "/password/email");
    }

}

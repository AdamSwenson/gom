<?php
namespace Page;

class LoginPage
{
    public static $testAccountEmail = 'test2@gradeomatic.net';
    public static $testAccountPassword = "testtest";

    //routes
    // include url of current page
    public static $URL = '/auth/login';
    public static $forgotPasswordUrl = 'http://localhost:8000/password/email';
    public static $forgotPasswordRoute = '/password/email';


    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //common
    public static $mainBodyLocator = ['id' => 'loginPage'];
    public static $pageHeadingText = "Login";
    public static $pageTitleText = "Login | gradeomatic";

    //fields
    public static $emailField = '//*[@id="email"]';
    public static $emailFieldLocator = ['id' => "email"];
    public static $passwordField = '//*[@id="password"]';
    public static $passwordFieldLocator = ['id' => "password"];

    public static $rememberField = '#remember';
    public static $rememberCheckLocator = ['id' => 'remember'];

    public static $loginButton = '#login';
    public static $loginButtonLocator = ['id' => 'login'];

    public static $forgotPasswordLinkLocator = ['id' => 'forgotPasswordLink'];
    public static $forgotPasswordLinkText = "Forgot Password";

    #messages
    public static $missingPasswordMessage = "The password field is required.";
    public static $missingEmailMessage = "The email field is required";
    public static $credentialErrorMessage = "These credentials do not match our records.";

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /* ---------------------------------- Utilities ---------------------------------- */
    public static function navigateToPage($I)
    {
        $I->amGoingTo("Visit the login page");
        $I->amOnPage('/auth/logout');
        $I->wait(1);
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }

    /* ---------------------------------- Assertions ------------------------------- */
    public static function assertPageIntact($I)
    {
        $I->expectTo('see the title and page level elements');
        $I->see(LoginPage::$pageHeadingText);
        $I->seeInTitle(LoginPage::$pageTitleText);
        $I->seeInCurrentUrl(LoginPage::$URL);

        $I->expectTo("see the main fields of the login page");
        $I->seeElement(self::$emailFieldLocator);
        $I->seeElement(self::$passwordFieldLocator);
        $I->seeElement(self::$loginButtonLocator);

        $I->expectTo('see the remember me checkbox');
        $I->seeElement(['id' => 'remember']);
        $I->see("Remember me");

        $I->expectTo('see the forgot password link');
        $I->seeElement(self::$forgotPasswordLinkLocator);
        $I->seeLink(self::$forgotPasswordLinkText, self::$forgotPasswordUrl);
    }

}

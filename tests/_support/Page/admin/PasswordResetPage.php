<?php
namespace Page\admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasswordResetPage
{
    // include url of current page
    public static $URL = '/password/reset';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //common
    public static $resetMainBodyLocator = ['id' => 'resetPassPage'];
    public static $emailMainBodyLocator = ['id' => 'resetPassEmailPage'];
    public static $pageTitleText = 'Reset Password | gradeomatic';
    public static $pageHeadingText = 'Reset Password';


    //fields
    public static $emailFieldLocator = ['id' => 'email'];
    public static $submitButtonLocator = ['id' => 'submit'];
    public static $submitButtonText = 'Send Password Reset Link';

    //reset page fields
    public static $passwordFieldLocator = ['id' => 'password'];
    public static $passwordConfirmFieldLocator = ['id' => 'password-confirm'];
    public static $resetSubmitButtonText = 'Reset Password';

    #messages
    public static $emailErrorMessage = "We can't find a user with that e-mail address.";

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /* --------------------------------- Utilities ------------------- */
    public static function navigateToEmailRequestPage($I){
        if(Auth::check()){
            $I->amOnPage('logout');
        }

        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$emailMainBodyLocator);
    }

    public static function navigateToResetPage($I, $token){
        if(Auth::check()){
            $I->amOnPage('logout');
        }

        $I->amOnPage(self::$URL . "/{$token}");
        $I->waitForElementVisible(self::$resetMainBodyLocator);
    }


    /* ----------------------------- Assertions ------------------------ */
    public static function assertEmailPageIntact($I)
    {
        $I->expectTo('see major page level elements');
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageHeadingText);
        $I->seeInCurrentUrl(self::$URL);

        $I->expectTo('see main form fields');
        $I->seeElement(self::$emailFieldLocator);
        $I->seeElement(self::$submitButtonLocator);
        $I->see(self::$submitButtonText, self::$submitButtonLocator);

    }

    public static function assertResetPageIntact($I)
    {
        $I->expectTo('see major page level elements');
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageHeadingText);

        $I->expectTo('see main form fields');
        $I->seeElement(self::$emailFieldLocator);
        $I->seeElement(self::$passwordFieldLocator);
        $I->seeElement(self::$passwordConfirmFieldLocator);
        $I->seeElement(self::$submitButtonLocator);
        $I->see(self::$resetSubmitButtonText, self::$submitButtonLocator);
    }

}

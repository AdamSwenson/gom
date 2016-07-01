<?php
namespace Page\admin;

use Illuminate\Support\Facades\Auth;

class PasswordResetPage
{
    // include url of current page
    public static $URL = '/password/email';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //common
    public static $mainBodyLocator = ['id' => 'resetPassPage'];
    public static $pageTitleText = 'Reset Password | gradeomatic';
    public static $pageHeadingText = 'Reset Password';


    //fields
    public static $emailFieldLocator = ['id' => 'email'];
    public static $submitButtonLocator = ['id' => 'submit'];
    public static $submitButtonText = 'Send Email';

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
    public static function navigateToPage($I){
        if(Auth::check()){
            $I->amOnPage('/auth/logout');
        }

        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }

    /* ----------------------------- Assertions ------------------------ */
    public static function assertPageIntact($I)
    {
        $I->expectTo('see major page level elements');
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageHeadingText);
        $I->seeInCurrentUrl(self::$URL);

        $I->expectTo('see main form fields');
        $I->seeElement(self::$emailFieldLocator);
        $I->seeElement(self::$submitButtonLocator);
        $I->seeInField(self::$submitButtonLocator, self::$submitButtonText);

    }

}

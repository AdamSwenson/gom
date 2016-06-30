<?php
namespace Page\admin;

class AccountCreatePage
{
    // include url of current page
    public static $URL = '/auth/register';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    #common
    public static $mainBodyLocator = ['id' => 'registrationPage'];
    public static $pageTitleText = 'Sign Up | gradeomatic';
    public static $pageHeadingText = 'Create Account';

    #fields
    public static $userNameLocator = ['id' => 'name'];
    public static $emailLocator = ['id' => 'email'];
    public static $passwordLocator = ['id' => 'pwd'];
    public static $confirmPasswordLocator = ['id' => 'pwd_conf'];
    public static $submitButtonLocator = ['id' => 'submit'];
    public static $submitButtonText = 'Create Account';

    //error messages
    public static $mismatchMessage = "The password confirmation does not match.";
    public static $usernameMessage = "The name field is required";
    public static $passwordMissingMessage = "The password field is required";
    public static $emailMissingMessage = "Your email is required";
    public static $emailInvalidMessage = "Please enter a valid email address";
    //Your email is required

    public static function assertPageIntact($I)
    {
        $I->seeInCurrentUrl(self::$URL);

        $I->seeInTitle(AccountCreatePage::$pageTitleText);
        $I->see(AccountCreatePage::$pageHeadingText);

        $I->seeElement(AccountCreatePage::$userNameLocator, ['name' => 'name']);
        $I->seeElement(AccountCreatePage::$emailLocator, ['name' => 'email']);
        $I->seeElement(AccountCreatePage::$passwordLocator, ['name' => 'password']);

        $I->seeElement(AccountCreatePage::$confirmPasswordLocator, ['name' => 'password_confirmation']);

        $I->seeElement(AccountCreatePage::$submitButtonLocator);
    }


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

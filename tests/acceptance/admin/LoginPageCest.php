<?php
use Page\admin\PasswordResetPage;
use Page\LoginPage;
use Page\SetupExamSelectPage;


class LoginPageCest
{

    public function _before(AcceptanceTester $I)
    {
//        LoginPage::navigateToPage($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function checkLogInPageIntact(AcceptanceTester $I)
//    {
//        LoginPage::assertPageIntact($I);
//    }
//
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInHappyPath(AcceptanceTester $I)
//    {
//        $I->amGoingTo("Attempt to login ");
//        $I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
//        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
//        $I->click(LoginPage::$loginButton);
//
//        $I->amGoingTo("check that properly redirected to exam1 setup page");
//        $I->seeInCurrentUrl(SetupExamSelectPage::$URL);
//        $I->seeInTitle(SetupExamSelectPage::$pageTitleText);
//    }
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     * @param $scenario
//     */
//    public function followForgottenEmailLink(AcceptanceTester $I, $scenario)
//    {
//        $I->amGoingTo("click the 'forgot password' link and check that I am properly redirected");
//        $I->click(LoginPage::$forgotPasswordLinkLocator);
//
//        $I->expectTo("have been redirected to the reset page");
//        $I->waitForElementVisible(PasswordResetPage::$mainBodyLocator);
//        $I->seeInCurrentUrl(PasswordResetPage::$URL);
//    }
//
//    /* ------------------------------- Unhappy paths --------------------------- */
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInInvalidEmailInvalidFormat(AcceptanceTester $I, $scenario)
//    {
//        $I->amGoingTo("Submit a login attempt with a invalidly formatted email address");
//        $email = 'taco@taco';
//
//        $I->fillField(LoginPage::$emailField, $email);
//        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
//        $I->click(LoginPage::$loginButton);
//
//        $I->expectTo('be returned to the login page');
//        $I->seeInCurrentUrl(LoginPage::$URL);
//
//        $I->expectTo("see the appropriate error message");
//        $I->see(LoginPage::$credentialErrorMessage);
//    }
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInInvalidEmailBlank(AcceptanceTester $I)
//    {
//        $I->amGoingTo("Submit a login attempt leaving the email address field blank");
//
//        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
//        $I->click(LoginPage::$loginButton);
//
//        $I->expectTo('be returned to the login page');
//        $I->seeInCurrentUrl(LoginPage::$URL);
//
//        $I->expectTo("see the appropriate error message");
//        $I->see(LoginPage::$missingEmailMessage);
//    }
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInInvalidEmailNotExisting(AcceptanceTester $I)
//    {
//        $I->amGoingTo("Submit a login attempt with a validly formatted email address which does not match any existing account");
//        $email = 'validEmail@tacosForLife.edu';
//
//        $I->fillField(LoginPage::$emailField, $email);
//        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
//        $I->click(LoginPage::$loginButton);
//
//        $I->expectTo('be returned to the login page');
//        $I->seeInCurrentUrl(LoginPage::$URL);
//
//        $I->expectTo("see the appropriate error message");
//        $I->see(LoginPage::$credentialErrorMessage);
//    }
//
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInInvalidPasswordBlank(AcceptanceTester $I)
//    {
//        $I->am("going to attempt to log in without filling in the password field");
//
//        $I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
//        $I->click(LoginPage::$loginButton);
//
//        $I->expectTo('be returned to the login page');
//        $I->seeInCurrentUrl(LoginPage::$URL);
//
//        $I->expectTo("see the appropriate error message");
//        $I->see(LoginPage::$missingPasswordMessage);
//
//    }
//
//    /**
//     * @group admin
//     * @group login
//     * @param AcceptanceTester $I
//     */
//    public function logInInvalidPasswordMismatch(AcceptanceTester $I)
//    {
//        $I->am("going to attempt to log in with a password which does not match the stored password for the email address used");
//
//        $I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
//        $I->fillField(LoginPage::$passwordField, \Faker\Factory::create()->password);
//        $I->click(LoginPage::$loginButton);
//
//        $I->expectTo('be returned to the login page');
//        $I->seeInCurrentUrl(LoginPage::$URL);
//
//        $I->expectTo("see the appropriate error message");
//        $I->see(LoginPage::$credentialErrorMessage);
//    }
//

}
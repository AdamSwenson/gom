<?php
use Page\LoginPage;
use Page\SetupExamSelectPage;


class LoginPageCest
{

    public function _before(AcceptanceTester $I)
    {
        LoginPage::navigateToPage($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     */
    public function checkLogInPageIntact(AcceptanceTester $I)
    {
        LoginPage::assertPageIntact($I);
    }


    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     */
    public function logInHappyPath(AcceptanceTester $I)
    {
        $I->amGoingTo("Attempt to login ");
        $I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
        $I->click(LoginPage::$loginButton);

        $I->amGoingTo("check that properly redirected to exam setup page");
        $I->seeInCurrentUrl(SetupExamSelectPage::$URL);
        $I->seeInTitle(SetupExamSelectPage::$pageTitleText);
    }

    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     */
    public function logInInvalidEmail(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }

    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     */
    public function logInInvalidPassword(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }


    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function followForgottenEmailLink(AcceptanceTester $I, $scenario)
    {

    }
}
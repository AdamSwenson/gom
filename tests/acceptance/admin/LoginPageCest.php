<?php
use Page\LoginPage;
use Page\SetupExamSelectPage;


class LoginPageCest
{

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(LoginPage::$URL);
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
        $I->amOnPage('/auth/logout');
        LoginPage::assertPageIntact($I);
    }


    /**
     * @group admin
     * @group login
     * @param AcceptanceTester $I
     */
    public function logIn(AcceptanceTester $I)
    {
        $I->amGoingTo("Attempt to login ");
        $I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
        $I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
        $I->click(LoginPage::$loginButton);

        $I->amGoingTo("check that properly redirected to exam setup page");
        $I->seeInCurrentUrl(SetupExamSelectPage::$URL);
        $I->seeInTitle(SetupExamSelectPage::$pageTitleText);
    }


}
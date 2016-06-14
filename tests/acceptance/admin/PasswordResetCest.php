<?php


use Page\admin\PasswordResetPage;

class PasswordResetCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(PasswordResetPage::$URL);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group admin
     * @param AcceptanceTester $I
     */
    public function assertPageIntact(AcceptanceTester $I)
    {
        $I->seeInTitle(PasswordResetPage::$pageTitleText);
        $I->see(PasswordResetPage::$pageHeadingText);
        $I->seeInCurrentUrl(PasswordResetPage::$URL);

        $I->seeElement(PasswordResetPage::$emailFieldLocator);
        $I->seeElement(PasswordResetPage::$submitButtonLocator);
        $I->seeInField(PasswordResetPage::$submitButtonLocator, PasswordResetPage::$submitButtonText);
    }

    public function submitRequestValidEmail(AcceptanceTester $I)
    {
        $I->fillField(PasswordResetPage::$emailFieldLocator, "test2@gradeomatic.net");
        $I->click(PasswordResetPage::$submitButtonLocator);

    }

    public function submitRequestInvalidEmail(AcceptanceTester $I){
        $I->amGoingTo("enter an invalid email address and submit the form");
        $I->fillField(PasswordResetPage::$emailFieldLocator, 'taco@taco.net');
        $I->click(PasswordResetPage::$submitButtonLocator);
        $I->wait(2);
        $I->expectTo("see the error message");
        $I->see("We can't find a user with that e-mail address.");

    }

}

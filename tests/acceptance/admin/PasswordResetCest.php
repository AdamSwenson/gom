<?php


use Page\admin\PasswordResetPage;
use Page\SetupExamSelectPage;

class PasswordResetCest
{
    public function _before(AcceptanceTester $I)
    {
//        PasswordResetPage::navigateToPage($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

//    /**
//     * @group admin
//     * @group reset_password
//     * @param AcceptanceTester $I
//     */
//    public function assertPageIntact(AcceptanceTester $I)
//    {
//        PasswordResetPage::assertPageIntact($I);
//    }
//
//    /**
//     * @group admin
//     * @group reset_password
//     * @param AcceptanceTester $I
//     */
//    public function submitRequestValidEmail(AcceptanceTester $I)
//    {
//        $I->fillField(PasswordResetPage::$emailFieldLocator, "test2@gradeomatic.net");
//        $I->click(PasswordResetPage::$submitButtonLocator);
//
//        $I->expectTo("not see the error message");
//        $I->wait(3);
//        $I->dontSee("We can't find a user with that e-mail address.");
//
//    }
//
//    /**
//     * @group admin
//     * @group reset_password
//     * @param AcceptanceTester $I
//     */
//    public function submitRequestValidEmailNoExistingAccount(AcceptanceTester $I)
//    {
//        $I->amGoingTo("enter a valid email address which does not match an existing account and submit the form");
//        $I->fillField(PasswordResetPage::$emailFieldLocator, 'taco@taco.net');
//        $I->click(PasswordResetPage::$submitButtonLocator);
//        $I->wait(2);
//        $I->expectTo("see the error message");
//        $I->see("We can't find a user with that e-mail address.");
//
//    }
//
//    /**
//     * @group admin
//     * @group reset_password
//     * @param AcceptanceTester $I
//     */
//    public function submitRequestInvalidEmail(AcceptanceTester $I)
//    {
//        $I->amGoingTo("enter an invalidly formatted email address and submit the form");
//        $I->fillField(PasswordResetPage::$emailFieldLocator, 'taco@taco');
//        $I->click(PasswordResetPage::$submitButtonLocator);
//        $I->wait(2);
//
//        $I->expectTo("see the error message");
//        $I->see("We can't find a user with that e-mail address.");
//
//    }
}

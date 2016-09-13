<?php


use Page\admin\PasswordResetPage;
use Page\SetupExamSelectPage;
use Illuminate\Support\Facades\DB;


class PasswordResetEmailRequestCest
{

    public function _before(AcceptanceTester $I)
    {
        $I->log_out();
        PasswordResetPage::navigateToEmailRequestPage($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /* ----------------------------- Send reset email --------------- */
    /**
     * @group admin
     * @group reset_password
     * @group reset_password_email
     * @param AcceptanceTester $I
     */
    public function assertEmailPageIntact(AcceptanceTester $I)
    {
//        PasswordResetPage::navigateToEmailRequestPage($I);
        PasswordResetPage::assertEmailPageIntact($I);
    }

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_email
     * @param AcceptanceTester $I
     */
    public function submitRequestValidEmail(AcceptanceTester $I)
    {
//        PasswordResetPage::navigateToEmailRequestPage($I);
        $I->fillField(PasswordResetPage::$emailFieldLocator, "test2@gradeomatic.net");
        $I->click(PasswordResetPage::$submitButtonLocator);

        $I->expectTo("see the success message and not see the error message");
        $I->waitForElementVisible(PasswordResetPage::$emailMainBodyLocator);
        $I->dontSee("We can't find a user with that e-mail address.");
        $I->see("We have e-mailed your password reset link!");
    }

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_email
     * @param AcceptanceTester $I
     */
    public function submitRequestValidEmailNoExistingAccount(AcceptanceTester $I)
    {
//        PasswordResetPage::navigateToEmailRequestPage($I);
        $I->amGoingTo("enter a valid email address which does not match an existing account and submit the form");
        $I->fillField(PasswordResetPage::$emailFieldLocator, 'taco@taco.net');
        $I->click(PasswordResetPage::$submitButtonLocator);
        $I->waitForElementVisible(PasswordResetPage::$emailMainBodyLocator);
        $I->expectTo("see the error message");
        $I->see("We can't find a user with that e-mail address.");
    }

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_email
     * @param AcceptanceTester $I
     */
    public function submitRequestInvalidEmail(AcceptanceTester $I)
    {
//        PasswordResetPage::navigateToEmailRequestPage($I);
        $I->amGoingTo("enter an invalidly formatted email address and submit the form");
        $I->fillField(PasswordResetPage::$emailFieldLocator, 'taco@taco');
        $I->click(PasswordResetPage::$submitButtonLocator);
        $I->waitForElementVisible(PasswordResetPage::$emailMainBodyLocator);

        $I->expectTo("see the error message");
        $I->see("We can't find a user with that e-mail address.");
    }


}

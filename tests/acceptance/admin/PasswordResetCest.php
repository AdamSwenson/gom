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
}

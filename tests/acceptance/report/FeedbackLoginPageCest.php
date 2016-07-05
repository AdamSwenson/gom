<?php
use Page\report\FeedbackLoginPage;
use Page\report\FeedbackPage;


class FeedbackLoginPageCest
{
    public $accessKey = "634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b";
    public $invalidAccessKey = "tacos";


    public function _before(AcceptanceTester $I)
    {
        $I->test_login($I);
        $I->amOnPage(FeedbackLoginPage::$URL);
        $I->wait(2);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    /**
     * @param AcceptanceTester $I
     */
    public function checkPageIntact(AcceptanceTester $I)
    {

        $I->wantTo('Check that the login functions for students to see their feedback are working properly');

        FeedbackLoginPage::verifyPageIntact($I);
    }

    /**
     * @group curr_dev
     * @group feedback
     * @group report
     * @param AcceptanceTester $I
     */
    public function checkValidKeyRedirects(AcceptanceTester $I)
    {
        $I->amGoingTo("Check that a valid access key directs to the feedback page");
        $I->fillField(['id' => FeedbackLoginPage::$accessKeyFieldId], $this->accessKey);
        $I->click(['id' => FeedbackLoginPage::$submitButtonId]);

        $I->waitForElementVisible(FeedbackPage::$mainBodyLocator);
        $I->see($this->accessKey);
        
        $I->dontSee(FeedbackLoginPage::$submitButtonText);

    }

    /**
     * @group feedback
     * @group report
     * @param AcceptanceTester $I
     */
    public function checkInvalidKeyRedirects(AcceptanceTester $I)
    {
        $I->amGoingTo("Check that an invalid access key redirects properly");
        //go back to page
        $I->amOnPage(FeedbackLoginPage::$URL);
        $I->wait(2);
        FeedbackLoginPage::verifyPageIntact($I);

        $I->fillField(['id' => FeedbackLoginPage::$accessKeyFieldId], $this->invalidAccessKey);
        $I->click(['id' => FeedbackLoginPage::$submitButtonId]);
        $I->seeInCurrentUrl(FeedbackLoginPage::$URL); //still there
        $I->dontSee($this->invalidAccessKey);
        $I->see(FeedbackLoginPage::$submitButtonText);

    }

    /**
     * @group feedback
     * @group report
     * @param AcceptanceTester $I
     */
    public function checkNoKeyRedirectsToLogin(AcceptanceTester $I)
    {
        $I->expect("that if I go to the feedback route without an access key in the get request, I will be redirected to the login page");
        $I->amOnPage('/feedback');
        $I->wait(2);
        FeedbackLoginPage::verifyPageIntact($I);

    }

}
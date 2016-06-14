<?php
use Page\report\FeedbackLoginPage;

//@group feedback
//@group report

$accessKey = "634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b";
$invalidAccessKey = "tacos";


$I = new AcceptanceTester($scenario);
$I->wantTo('Check that the login functions for students to see their feedback are working properly');

$I->amOnPage(FeedbackLoginPage::$URL);
$I->wait(2);

FeedbackLoginPage::verifyPageIntact($I);

$I->amGoingTo("Check that a valid access key directs to the feedback page");
    $I->fillField(['id' => FeedbackLoginPage::$accessKeyFieldId], $accessKey);
    $I->click(['id' => FeedbackLoginPage::$submitButtonId]);
    $I->seeInCurrentUrl("/feedback?accessKey={$accessKey}");
    $I->see($accessKey);
    $I->dontSee(FeedbackLoginPage::$submitButtonText);


$I->amGoingTo("Check that an invalid access key redirects properly");
    //go back to page
    $I->amOnPage(FeedbackLoginPage::$URL);
    $I->wait(2);
    FeedbackLoginPage::verifyPageIntact($I);

    $I->fillField(['id' => FeedbackLoginPage::$accessKeyFieldId], $invalidAccessKey);
    $I->click(['id' => FeedbackLoginPage::$submitButtonId]);
    $I->seeInCurrentUrl(FeedbackLoginPage::$URL); //still there
    $I->dontSee($invalidAccessKey);
    $I->see(FeedbackLoginPage::$submitButtonText);


$I->expect("that if I go to the feedback route without an access key in the get request, I will be redirected to the login page");
    $I->amOnPage('/feedback');
    $I->wait(2);
    FeedbackLoginPage::verifyPageIntact($I);


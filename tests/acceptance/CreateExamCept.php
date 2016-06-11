<?php

use Page\ExamEditPage;

$scenario->group('setup');

$testExamName = "testExamName";

$I = new AcceptanceTester($scenario);
$I->wantTo('Create an exam and see it in the db');

$I->start_artisan();
//Log in
$I->test_login($I);

$I->amOnPage(ExamEditPage::$URL);

$I->amGoingTo("Check that see the right stuff");
$I->seeInTitle(ExamEditPage::$pageTitleText);
$I->seeInCurrentUrl(ExamEditPage::$URL);
$I->see(ExamEditPage::$pageHeadingText);

$I->amGoingTo("Fill in the name field");
$I->fillField(ExamEditPage::$examNameField, $testExamName);

$I->amGoingTo("Select Winter for the term");
$I->click('//*[@id="term"]');
$I->see('Winter');
$I->see('Spring');
$I->see('Summer');
$I->see('Fall');
//first item on list, i.e., Winter
$I->click('//*[@id="termList"]/li[1]/a');
$I->see('Winter');
$I->dontSee('Spring');
$I->dontSee('Summer');
$I->dontSee('Fall');
//grab the value for testing
$testTerm = $I->grabTextFrom('//*[@id="term"]');
$I->amGoingTo('tell you that I grabbed this for term ' . $testTerm);

$I->amGoingTo('Select the second year from the list');
//click to display the list of options
$I->click('//*[@id="year"]');
//select the list item
$I->click('//*[@id="yearList"]/li[2]/a');
//grab value for testing
$testYear = $I->grabTextFrom('//*[@id="year"]');
$I->amGoingTo('tell you that I grabbed this for year ' . $testYear);


$I->amGoingTo("Submit the form");
$I->click(ExamEditPage::$forwardNavButton);

$I->amGoingTo("Check the db for the record");
$I->seeInDatabase('exams', [
    'user_id'  => 1,
//    'term'     => $testTerm,
//    'year'     => $testYear,
    'name'     => $testExamName,
//    'locked'   => 0,
//    'released' => 0,
]);

$I->amGoingTo("Check that I was redirected properly");
$I->see("Add / Edit Questions");
$I->seeInCurrentUrl('/question/edit');


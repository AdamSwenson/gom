<?php
use Page\GradingPage;

$examId = 1;

$I = new AcceptanceTester($scenario);
$I->wantTo('Check the grading page to make sure everything works properly');

$I->test_login($I);
$I->amOnPage(GradingPage::route($examId);
$I->wait(2);


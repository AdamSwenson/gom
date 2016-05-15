<?php
use Page\report\ReportIndexPage;

$examWithNoGradedId = 6;
$examWithNoQuestionsId = 5;

$I = new FunctionalTester($scenario);
$I->logIn($I);
$I->disableMiddleware();
//$I->amOnPage(ReportIndexPage::$URL);
//$I->wait(2);

$I->wantTo('Test out the case where someone tries to release an exam which has no graded students');
$I->sendAjaxPostRequest("report/{$examWithNoGradedId}/release");
$I->seeResponseCodeIs(200);

$I->wantTo('Test out the case where someone tries to release an exam which has no questions');
$I->sendAjaxPostRequest("report/{$examWithNoQuestionsId}/release");
$I->seeResponseCodeIs(200);
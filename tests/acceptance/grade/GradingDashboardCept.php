<?php
use Page\grade\GradingPage;

$examId = 1;
$studentRowId = 1;
$numQuestions = 5;
$numElements  = 5;

$scenario->group('grade');
$I = new AcceptanceTester($scenario);
$I->wantTo('Confirm that the statistics and other dashboard features seen while grading are operating properly');

$I->test_login($I);
$I->amOnPage(GradingPage::route($examId));
$I->wait(2);

GradingPage::verifyGradingPageIntact($I, $examId);

$I->amGoingTo("Click the student row {$studentRowId} and check that see expected dashboard changes happen  (other page components are checked elsewhere)");
    $I->dontSeeElement(['id' => 'questionPanel']);
    GradingPage::clickStudentRow($I, $studentRowId);
    $I->see('Question #1: "Exam1Question1"');

//toggle timer

//check timer says runningTimer: toggle
//check stats

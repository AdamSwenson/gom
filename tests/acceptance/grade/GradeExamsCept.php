<?php
use Page\grade\GradingPage;

$examId = 2; //nothing graded
$studentRowId = 1;
$studentNumber = 1;//the number which will be in the name of the student
$numQuestions = 5;
$numElements = 5;
$maxScore = 100;

$scenario->group('grade');
$I = new AcceptanceTester($scenario);
$I->wantTo('Check the grading page to make sure the everything is in its place and that the large scale page changes work properly. More detailed grading operations are tested in other files');

$I->test_login($I);
$I->amOnPage(GradingPage::route($examId));
$I->wait(3);


GradingPage::verifyGradingPageIntact($I, $examId);


$I->wantTo("Click the student row {$studentRowId} and check that see everything expected (except for dashboard related changes, which are checked elsewhere)");
    $I->dontSeeElement(['id' => 'questionPanel']);
    GradingPage::clickStudentRow($I, $studentRowId);
$I->wait(1);
    $I->expectTo("see the selected student's name in the active student field");
        $I->seeInField(GradingPage::$activeStudentNameFieldXPath, "lastNameOfExisting{$studentNumber}, firstNameOfExisting{$studentNumber}");

    $I->expectTo("see that the question fields have displayed");
        $I->see('Question #1: "Exam' . $examId . 'Question1"');
        for ( $i = 1; $i <= $numQuestions; $i++ )
        {
            $I->expectTo("see the question tab for q{$i}");
            $I->see("Q{$i}");
            $I->seeElement(GradingPage::questionPanelTabXPath($i));
        }


$I->wantTo("Click the question tabs and check that expected things display");
    //start at q2 because q1 is currently displayed
    for ( $i = 2; $i <= $numQuestions; $i++ )
    {
        GradingPage::clickQuestionTab($I, $i);
        GradingPage::verifyQuestionPanelIntact($I, $i, $numElements);
    }
    $I->amGoingTo("go back and check question 1 (since it was showing when we started the test");
    GradingPage::clickQuestionTab($I, 1);
    GradingPage::verifyQuestionPanelIntact($I, 1, $numElements);


$I->wantTo("Click the grade blind icon and see that the student names are hidden");

$I->wantTo("See the default message if there are no elements for a question");

//switch student

//switch back to first student

//test typeahead
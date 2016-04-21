<?php
use Page\QuestionEditPage;

$examId = 4;
$examName= "TestExam#4 NoQuestions User1";

//The number of question areas displayed initially
$numQuestions = 5;

//Test data (skipping a question to check for unexpected behavior
//if the user leaves a question blank
$question1Name = "Name of new question #1";
$question1Text = "Text of new question #1";
$question1MaxScore = 88;
$question3Name = "Name of new question #2";
$question3Text = "Text of new question #2";
$question3MaxScore = 38;

$I = new AcceptanceTester($scenario);
$I->wantTo('Add questions to an exam which has no questions');
$I->test_login($I);
$I->amOnPage("exam/{$examId}/question/edit");


$I->amGoingTo("Check that everything is displayed properly");
    $I->seeInTitle(QuestionEditPage::$pageTitleText);
    $I->see($examName);
    $I->seeElement(QuestionEditPage::$addQuestionButtonId);
    //correct navs
    $I->seeElement(QuestionEditPage::$forwardNavButton);
    $I->seeElement(QuestionEditPage::$backNavButton);
    //fields present
    for($i=1; $i <= $numQuestions; $i++){
        $I->checkQuestionFieldsPresent($I, $i);
    }


$I->amGoingTo("Add a sixth question field");
    //check that a question 6 isn't already present
    $I->checkQuestionFieldsPresent($I, 6, true);
    //click the add button
    $I->click(QuestionEditPage::$addQuestionButtonId);
    //check that a sixth question field is present
    $I->checkQuestionFieldsPresent($I, 6);


$I->amGoingTo("Enter text in two question fields");
    $I->fillField(QuestionEditPage::questionNameXPath(1), $question1Name);
    $I->fillField(QuestionEditPage::questionTextXPath(1), $question1Text);
    $I->fillField(QuestionEditPage::maxScoreXPath(1), $question1MaxScore);
    $I->fillField(QuestionEditPage::questionNameXPath(3), $question3Name);
    $I->fillField(QuestionEditPage::questionTextXPath(3), $question3Text);
    $I->fillField(QuestionEditPage::maxScoreXPath(3), $question3MaxScore);



$I->amGoingTo("Submit the form and check that I'm properly redirected");
    $I->click(QuestionEditPage::$forwardNavButton);
    $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($examId));


$I->amGoingTo("Go back to the edit page and see the changed questions");


$I->amGoingTo("Totally unnecessarily but nonetheless obsessively check that the database has changed");
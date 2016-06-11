<?php
use Page\QuestionEditPage;


$scenario->group(['setup', 'question']);

$examId = 5;
$examName= "TestExam#5 NoQuestions User1";

//The number of question areas displayed initially. Storing in variable so can update
$numQuestions = QuestionEditPage::$defaultNumberOfQuestions;

//TODO Do we want to test the case where we skip a question to check for unexpected behavior if the user leaves a question blank?


$I = new AcceptanceTester($scenario);
$I->wantTo('Add questions to an exam which has no questions');
$I->test_login($I);
$I->wait(2);
$I->amOnPage("exam/{$examId}/question/edit");
QuestionEditPage::verifyQuestionEditPageIntact($I, $examId, $examName, $numQuestions);


$I->amGoingTo("Add a second question field");
    //check that a question 2 isn't already present
    QuestionEditPage::checkQuestionFieldsPresent($I, 2, true);
    //click the add button
    $I->click(QuestionEditPage::$addQuestionButtonId);
    //check that a second question field is present
    QuestionEditPage::checkQuestionFieldsPresent($I, 2);
    $numQuestions += 1;


$I->amGoingTo("Enter text in the question fields");
    $testData = $I->generateQuestionTestData($numQuestions);
    for($i=1; $i<= $numQuestions; $i++){
        $I->fillField(QuestionEditPage::questionNameXPath($i), $testData[$i]['name']);
        $I->fillField(QuestionEditPage::questionTextXPath($i), $testData[$i]['text']);
        $I->fillField(QuestionEditPage::maxScoreXPath($i), $testData[$i]['maxScore']);
    }


$I->amGoingTo("Submit the form and check that I'm properly redirected");
    $I->click(QuestionEditPage::$forwardNavButton);
//Can't do this because don't know id of newly created question without making this really fragile
//    $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($examId, $qu));


$I->amGoingTo("Go back to the edit page and see the changed questions");
    $I->amOnPage("exam/{$examId}/question/edit");
    $I->wait(2);
    QuestionEditPage::verifyQuestionEditPageIntact($I, $examId, $examName, $numQuestions);
//
//    $I->verifyQuestionEditPageIntact($I, $examName, $numQuestions);
    for($i=1; $i<= $numQuestions; $i++){
        $I->seeInField(QuestionEditPage::questionNameXPath($i), $testData[$i]['name']);
        $I->seeInField(QuestionEditPage::questionTextXPath($i), $testData[$i]['text']);
        $I->seeInField(QuestionEditPage::maxScoreXPath($i), $testData[$i]['maxScore']);
    }

<?php
use Page\ElementEditPage;
use Page\QuestionEditPage;

$examId = 2;
$examName = "TestExam#2 5QuestionsWElements User1";
//The number of questions on the exam
$numQuestions = 5;

//test data
$newMaxScore = 54;
//will be prepended to form the new name and text
$prependedText = "New_";
$editedQuestionNumber = 2;
$swappedQuestionNumbers = [1, 3];
$deletedQuestionNumber = 4;
//this is the number of the question which moves up
$replacedDeletedQuestionNumber = 5;


$I = new AcceptanceTester($scenario);
$I->wantTo('Edit existing questions');
$I->test_login($I);
$I->amOnPage("exam/{$examId}/question/edit");

$I->amGoingTo("Check that the page looks as expected");
    $I->seeInTitle(QuestionEditPage::$pageTitleText);
    $I->see($examName);
    $I->seeElement(QuestionEditPage::$addQuestionButtonId);
    //correct navs
    $I->seeElement(QuestionEditPage::$forwardNavButton);
    $I->seeElement(QuestionEditPage::$backNavButton);
    //make sure have expected preexisting text
    for ( $i = 1; $i <= $numQuestions; $i++ )
    {
        $v = $I->getQuestionFieldsInitialValues($examId, $i);
        $I->seeElement(QuestionEditPage::questionNameXPath($i));
        $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
        $I->seeElement(QuestionEditPage::questionTextXPath($i));
        $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
        $I->seeElement(QuestionEditPage::maxScoreXPath($i));
        $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
    }


$I->amGoingTo("Edit the name, text, and max score of question #{$editedQuestionNumber}");
    $v = $I->getQuestionFieldsInitialValues($examId, $editedQuestionNumber);
    $I->fillField(QuestionEditPage::questionNameXPath($editedQuestionNumber), $prependedText . $v['questionName']);
    $I->fillField(QuestionEditPage::questionTextXPath($editedQuestionNumber), $prependedText . $v['questionText']);
    $I->fillField(QuestionEditPage::maxScoreXPath($editedQuestionNumber), $newMaxScore);


$I->amGoingTo("Swap the positions of questions #{$swappedQuestionNumbers[0]} and #{$swappedQuestionNumbers[1]}");


$I->amGoingTo("Delete question #{$deletedQuestionNumber}");
    $I->click(QuestionEditPage::deleteButtonXPath($deletedQuestionNumber));
    //question 5 should have become the new question 4, so there's no longer a question 5
    $I->checkQuestionFieldsPresent($I, $deletedQuestionNumber);
    $I->checkQuestionFieldsPresent($I, $replacedDeletedQuestionNumber, true);
    //check that the new question 4 has the values previously had by question 5
    $v = $I->getQuestionFieldsInitialValues($examId, $replacedDeletedQuestionNumber);
    $I->seeInField(QuestionEditPage::questionNameXPath($deletedQuestionNumber), $v['questionName']);
    $I->seeInField(QuestionEditPage::questionTextXPath($deletedQuestionNumber), $v['questionText']);
    $I->seeInField(QuestionEditPage::maxScoreXPath($deletedQuestionNumber), $v['maxScore']);


$I->amGoingTo("Submit the form and check that I'm properly redirected");
    $I->click(QuestionEditPage::$forwardNavButton);
    $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($examId));


$I->amGoingTo("Go back to the edit page and see the changed questions");


$I->amGoingTo("Totally unnecessarily but nonetheless obsessively check that the database has changed");
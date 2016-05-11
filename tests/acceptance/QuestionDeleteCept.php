<?php
use Page\QuestionEditPage;

$deletedQuestionNumber = 4;
//this is the number of the question which moves up
$replacedDeletedQuestionNumber = 5;

$examId = 2;
$examName = "TestExam#2 5QuestionsWElements User1";
//The number of questions on the exam
$numQuestions = 5;
//the id of question 1, for building the redirection route
$firstQuestionId = 6;


$I = new AcceptanceTester($scenario);
$I->wantTo('Delete questions and see them removed in the db');
$I->test_login($I);
$I->amOnPage("exam/{$examId}/question/edit");
$I->wait(2);

$I->verifyQuestionEditPageIntact($I, $examId, $examName, $numQuestions);
$I->verifyQuestionsHaveInitialExpectedValues($I, $examId, $numQuestions);


$I->amGoingTo("Start deleting question #{$deletedQuestionNumber} but cancel the operation with the confirmation modal");
    $I->dontSee(QuestionEditPage::$deleteConfirmationModalText);
//Searches for the link text
$I->click("//*[@id='deleteQuestionButton{$deletedQuestionNumber}']");
//$I->click('Delete', "#questionItem4");
//$I->click(QuestionEditPage::deleteButtonXPath($deletedQuestionNumber));
//$I->click("//*[@id='deleteQuestionButton4']");
$I->wait(2);

    //check can see warning
    $I->seeElement(".cancelQuestionDelete");
    //$I->see(QuestionEditPage::$deleteConfirmationModalText);
    //click cancel
    $I->click(QuestionEditPage::$deleteConfirmationModalCancelButton);
    $I->wait(2);
    //check modal closed
    $I->dontSee(QuestionEditPage::$deleteConfirmationModalText);
    //check that nothing changed on page
    $I->verifyQuestionEditPageIntact($I, $examName, $numQuestions);
    $I->verifyQuestionsHaveInitialExpectedValues($I, $examId, $numQuestions);


$I->amGoingTo("Delete question #{$deletedQuestionNumber}");
    $I->click("//*[@id='deleteQuestionButton{$deletedQuestionNumber}']");
    $I->wait(2);
    //confirmation modal
//    $I->see('.modal-dialog');
    $I->see(QuestionEditPage::$deleteConfirmationModalText);
    $I->click(QuestionEditPage::$deleteConfirmationModalConfirmButton);
    $I->wait(2);
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
    $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($examId, $firstQuestionId));


$I->amGoingTo("Go back to the edit page and see the changed questions");
    $I->amOnPage("exam/{$examId}/question/edit");
    $I->verifyQuestionEditPageIntact($I, $examId, $examName, $numQuestions);
//$I->seeInTitle(QuestionEditPage::$pageTitleText);
//$I->see($examName);
//$I->seeElement(QuestionEditPage::$addQuestionButtonId);
////correct navs
//$I->seeElement(QuestionEditPage::$forwardNavButton);
//$I->seeElement(QuestionEditPage::$backNavButton);
//make sure have expected text given the edits
for ( $i = 1; $i <= $numQuestions; $i++ )
{
    switch($i){

        case $deletedQuestionNumber:
            //Since we deleted questionNumber 4, the text displayed as questionNumber 4
            //should be the text which originally belonged to questionNumber 5.
            $v = $I->getQuestionFieldsInitialValues($examId, $i + 1);
            $I->seeElement(QuestionEditPage::questionNameXPath($deletedQuestionNumber));
            $I->seeInField(QuestionEditPage::questionNameXPath($deletedQuestionNumber), $v['questionName']);
            $I->seeElement(QuestionEditPage::questionTextXPath($deletedQuestionNumber));
            $I->seeInField(QuestionEditPage::questionTextXPath($deletedQuestionNumber), $v['questionText']);
            $I->seeElement(QuestionEditPage::maxScoreXPath($deletedQuestionNumber));
            $I->seeInField(QuestionEditPage::maxScoreXPath($deletedQuestionNumber), $v['maxScore']);
            //We should no longer see the text originally belonging to questionNumber 4
            $v2 = $I->getQuestionFieldsInitialValues($examId, $deletedQuestionNumber);
            $I->seeInField(QuestionEditPage::questionNameXPath($deletedQuestionNumber), $v2['questionName']);
            $I->seeInField(QuestionEditPage::questionTextXPath($deletedQuestionNumber), $v2['questionText']);
            $I->seeInField(QuestionEditPage::maxScoreXPath($deletedQuestionNumber), $v2['maxScore']);
            break;

        case $replacedDeletedQuestionNumber:
            //We are on the number of the question which moved up when the other question was deleted.
            //Thus this is questionNumber 5 because questionNumber 4 was deleted.
            //There was no questionNumber 6, so we should no longer see the fields for questionNumber 5.
            $I->dontSeeElement(QuestionEditPage::questionNameXPath($i));
            $I->dontSeeElement(QuestionEditPage::questionTextXPath($i));
            $I->dontSeeElement(QuestionEditPage::maxScoreXPath($i));
            break;

        default:
            $v = $I->getQuestionFieldsInitialValues($examId, $i);
            $I->seeElement(QuestionEditPage::questionNameXPath($i));
            $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
            $I->seeElement(QuestionEditPage::questionTextXPath($i));
            $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
            $I->seeElement(QuestionEditPage::maxScoreXPath($i));
            $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
    }
}

<?php

use Page\BootboxModals;
use Page\QuestionEditPage;


class QuestionDeleteCest
{
    public $deletedQuestionNumber = 4;
//this is the number of the question which moves up
    public $replacedDeletedQuestionNumber = 5;
    public $examId = 2;
    public $examName = "TestExam#2 5QuestionsWElements User1";
//The number of questions on the exam
    public $numQuestions = 5;
//the id of question 1, for building the redirection route
    public $firstQuestionId = 6;


    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Delete questions and see them removed in the db');
        QuestionEditPage::navigateToPage($I, $this->examId);
//        $I->test_login($I);
//        $I->amOnPage("exam/{$this->examId}/question/edit");
//        $I->wait(2);
//        $I->waitForElement(['id' => 'scriptBox']);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group setup
     * @group question
     */
    public function verifyInitialContent(AcceptanceTester $I)
    {
        $I->wantTo("see that the page is as I initially expect");
        QuestionEditPage::verifyQuestionEditPageIntact($I, $this->examId, $this->examName, $this->numQuestions);
        QuestionEditPage::verifyQuestionsHaveInitialExpectedValues($I, $this->examId, $this->numQuestions);
    }

    /**
     * @group setup
     * @group question
     */
    public function clickDelete(AcceptanceTester $I)
    {
        $I->wantTo("Delete question #{$this->deletedQuestionNumber}");
        $I->amGoingTo("Click the delete button");
        $I->wait(5);
        $I->seeElement(QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber));
        $I->dragAndDrop(QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber), QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber));
//$I->executeJS(" $('#deleteQuestionButton{$deletedQuestionNumber}').click(); ");
//$I->click(['id' => "deleteQuestionButton{$deletedQuestionNumber}"]);
//$I->click(QuestionEditPage::deleteButtonLocator($deletedQuestionNumber));
        BootboxModals::waitForBootboxModal($I);
        $I->wait(2);

        $I->expectTo("see the question delete confirmation modal");
        $I->seeElement(['id' => QuestionEditPage::$deleteConfirmationTextId]);
        $I->see(QuestionEditPage::$deleteConfirmationModalText);
        $I->click(QuestionEditPage::$deleteConfirmationModalConfirmButton);
        BootboxModals::waitForBootboxModal($I, false, true);
        $I->wait(2);

        $I->expect("question 5 to have become the new question 4, so there's no longer a question 5");
        QuestionEditPage::checkQuestionFieldsPresent($I, $this->deletedQuestionNumber);
        QuestionEditPage::checkQuestionFieldsPresent($I, $this->replacedDeletedQuestionNumber, true);

        $I->amGoingTo("check that the new question 4 has the values previously had by question 5");
        $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->replacedDeletedQuestionNumber);
        $I->seeInField(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber), $v['questionName']);
        $I->seeInField(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber), $v['questionText']);
        $I->seeInField(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber), $v['maxScore']);
    }

    public function submitAndCheckRedirection(AcceptanceTester $I)
    {
        $I->amGoingTo("Submit the form and check that I'm properly redirected");
        $I->click(QuestionEditPage::$forwardNavButton);
        $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($this->examId, $this->firstQuestionId));
    }

    public function checkStoredChanges(AcceptanceTester $I)
    {

        $I->amGoingTo("Go back to the edit page and see the changed questions");
        $I->amOnPage("exam/{$this->examId}/question/edit");
        QuestionEditPage::verifyQuestionEditPageIntact($I, $this->examId, $this->examName, $this->numQuestions);

        //make sure have expected text given the edits
        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            switch ( $i )
            {

                case $this->deletedQuestionNumber:
                    //Since we deleted questionNumber 4, the text displayed as questionNumber 4
                    //should be the text which originally belonged to questionNumber 5.
                    $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $i + 1);
                    $I->seeElement(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber), $v['questionName']);
                    $I->seeElement(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber), $v['questionText']);
                    $I->seeElement(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber), $v['maxScore']);
                    //We should no longer see the text originally belonging to questionNumber 4
                    $v2 = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->deletedQuestionNumber);
                    $I->seeInField(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber), $v2['questionName']);
                    $I->seeInField(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber), $v2['questionText']);
                    $I->seeInField(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber), $v2['maxScore']);
                    break;

                case $this->replacedDeletedQuestionNumber:
                    //We are on the number of the question which moved up when the other question was deleted.
                    //Thus this is questionNumber 5 because questionNumber 4 was deleted.
                    //There was no questionNumber 6, so we should no longer see the fields for questionNumber 5.
                    $I->dontSeeElement(QuestionEditPage::questionNameXPath($i));
                    $I->dontSeeElement(QuestionEditPage::questionTextXPath($i));
                    $I->dontSeeElement(QuestionEditPage::maxScoreXPath($i));
                    break;

                default:
                    $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $i);
                    $I->seeElement(QuestionEditPage::questionNameXPath($i));
                    $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
                    $I->seeElement(QuestionEditPage::questionTextXPath($i));
                    $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
                    $I->seeElement(QuestionEditPage::maxScoreXPath($i));
                    $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
            }

        }
    }

}

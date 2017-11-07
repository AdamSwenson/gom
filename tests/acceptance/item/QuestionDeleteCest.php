<?php

use Page\BootboxModals;
use Page\QuestionEditPage;


class ItemQuestionDeleteCest
{
    public $deletedQuestionNumber = 4;
//this is the number of the question which moves up
    public $replacedDeletedQuestionNumber = 5;
    public $examId = 2;
    public $examName = "TestExam#2 5QuestionsWElements User1";
//The number of questions on the exam1
    public $numQuestions = 5;
//the id of question 1, for building the redirection route
    public $firstQuestionId = 6;


    public function _before(AcceptanceTester $I)
    {
        QuestionEditPage::navigateToPage($I, $this->examId);
//        $I->waitForElement(['id' => 'loadComplete']);
    }


    

    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
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
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function clickDelete(AcceptanceTester $I, $scenario)
    {
        //Something weird about the sortable library prevents this
        //from running properly in test. As far as I can tell, the
        //sortable stuff never gets bound to events in the page
        $scenario->incomplete();

        $I->wantTo("Delete question 4");
        
        $I->expect("that the confirmation modal is not visible");
        $I->dontSeeElement(QuestionEditPage::$confirmationModalLocator);
        
        $I->amGoingTo("Click the delete button");
        $I->seeElement(QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber));

       // $I->dragAndDrop(QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber), QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber));
        $I->click(QuestionEditPage::deleteButtonLocator($this->deletedQuestionNumber));
        $I->waitForElementVisible(QuestionEditPage::$confirmationModalLocator);
        
        $I->expectTo("see the components of the delete confirmation modal");
        $I->seeElement(QuestionEditPage::$deleteConfirmationModalText);
        $I->seeElement(QuestionEditPage::$deleteConfirmButtonLocator);
        $I->seeElement(QuestionEditPage::$deleteCancelButtonLocator);

        $I->amGoingTo("click the confirmation button and wait for the modal to close");
        $I->click(QuestionEditPage::$deleteConfirmButtonLocator);
        $I->waitForElementNotVisible(QuestionEditPage::$confirmationModalLocator);

        $I->expect("that the confirmation modal is invisible");
        $I->dontSeeElement(QuestionEditPage::$confirmationModalLocator);
        $I->dontSeeElement(QuestionEditPage::$deleteConfirmButtonLocator);
        $I->dontSeeElement(QuestionEditPage::$deleteCancelButtonLocator);

        $I->expect("question 5 to have become the new question 4, so there's no longer a question 5");
        QuestionEditPage::checkQuestionFieldsPresent($I, $this->deletedQuestionNumber);
        QuestionEditPage::checkQuestionFieldsPresent($I, $this->replacedDeletedQuestionNumber, true);

        $I->expect("that the new question 4 has the values previously had by question 5");
        $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->replacedDeletedQuestionNumber);
        $I->seeInField(['xpath' => QuestionEditPage::questionNameXPath( $this->deletedQuestionNumber)], $v['questionName']);
        $I->seeInField(['xpath' => QuestionEditPage::questionTextXPath($this->deletedQuestionNumber)], $v['questionText']);
        $I->seeInField(['xpath' => QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber)], $v['maxScore']);
    }

    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function submitAndCheckRedirection(AcceptanceTester $I)
    {
        $I->amGoingTo("Submit the form and check that I'm properly redirected");
        $I->click(QuestionEditPage::$forwardNavButton);

        $I->expect("that I am on the edit page for the first element");
        $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($this->examId, $this->firstQuestionId));
    }


    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function checkStoredChanges(AcceptanceTester $I, $scenario)
    {

        //Something weird about the sortable library prevents this
        //from running properly in test. As far as I can tell, the
        //sortable stuff never gets bound to events in the page
        $scenario->incomplete();


        $I->amGoingTo("Go back to the edit page and see the changed questions");
        $I->amOnPage("exam1/{$this->examId}/question/edit");
        QuestionEditPage::verifyQuestionEditPageIntact($I, $this->examId, $this->examName, $this->numQuestions);

        //make sure have expected right given the edits
        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            switch ( $i )
            {

                case $this->deletedQuestionNumber:
                    //Since we deleted questionNumber 4, the right displayed as questionNumber 4
                    //should be the right which originally belonged to questionNumber 5.
                    $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $i + 1);
                    $I->seeElement(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::questionNameXPath($this->deletedQuestionNumber), $v['questionName']);
                    $I->seeElement(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::questionTextXPath($this->deletedQuestionNumber), $v['questionText']);
                    $I->seeElement(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber));
                    $I->seeInField(QuestionEditPage::maxScoreXPath($this->deletedQuestionNumber), $v['maxScore']);
                    //We should no longer see the right originally belonging to questionNumber 4
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

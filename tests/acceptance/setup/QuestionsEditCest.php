<?php
use Page\ElementEditPage;
use Page\QuestionEditPage;


class QuestionEditCest
{
    public $examId = 2;
    public $examName = "TestExam#2 5QuestionsWElements User1";
//The number of questions on the exam1
    public $numQuestions = 5;

//test data
    public $newMaxScore = 54;
//will be prepended to form the new name and text
    public $prependedText = "New_";
    public $editedQuestionNumber = 4;
    public $swappedQuestionNumbers = [1, 3];
    
//The questionId of questionNumber 1.
//This will be used to check that we are properly redirected.
    public $firstQuestionId = 6;


    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Edit existing questions');
        QuestionEditPage::navigateToPage($I, $this->examId);
    }

    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        QuestionEditPage::verifyQuestionEditPageIntact($I, $this->examId, $this->examName, $this->numQuestions);
    }

    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function editQuestion(AcceptanceTester $I)
    {
        $I->amGoingTo("Edit the name, text, and max score of an existing question");
        $v = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->editedQuestionNumber);
        $I->fillField(['xpath' => QuestionEditPage::questionNameXPath($this->editedQuestionNumber)], $this->prependedText . $v['questionName']);
        $I->fillField(['xpath' => QuestionEditPage::questionTextXPath($this->editedQuestionNumber)], $this->prependedText . $v['questionText']);
        $I->fillField(['xpath' => QuestionEditPage::maxScoreXPath($this->editedQuestionNumber)], $this->newMaxScore);

        $I->amGoingTo("Submit the form and check that I'm properly redirected");
        $I->click(QuestionEditPage::$forwardNavButton);

        $I->expectTo("be on redirected to the element edit page");
        $I->waitForElementVisible(ElementEditPage::$mainBodyLocator);

        $I->amGoingTo("Go back to the edit page and see the changed questions");
        $I->amOnPage("exam1/{$this->examId}/question/edit");
        $I->waitForElement(QuestionEditPage::$mainBodyLocator);

        $I->expectTo('see the changed values');
        $I->seeInField(['xpath' => QuestionEditPage::questionNameXPath($this->editedQuestionNumber)], $this->prependedText . $v['questionName']);
        $I->seeInField(['xpath' => QuestionEditPage::questionTextXPath($this->editedQuestionNumber)], $this->prependedText . $v['questionText']);

        $I->seeInField(['xpath' => QuestionEditPage::maxScoreXPath($this->editedQuestionNumber)], $this->newMaxScore);


    }


    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function reorderQuestions(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();

        $I->amGoingTo("Swap the positions of questions");
        $originalQuestionNumberOfMovedQuestion = $this->swappedQuestionNumbers[1];
        $targetQuestionNumber = $this->swappedQuestionNumbers[0];
        $movedQuestionValues = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->swappedQuestionNumbers[1]);
        $targetQuestionValues = QuestionEditPage::getQuestionFieldsInitialValues($this->examId, $this->swappedQuestionNumbers[0]);
        $I->dragAndDrop(QuestionEditPage::moveButtonLocator(3), ['id' => 'questionItem1']);
        $I->wait(5);

//$I->dragAndDrop("#moveQuestionButton{$swappedQuestionNumbers[1]}", "#moveQuestionButton{$swappedQuestionNumbers[0]}");
//
//$I->amGoingTo("See that the question which was questionNumber 3 should now be questionNumber 1.");
//    $I->seeInField(QuestionEditPage::questionNameXPath($targetQuestionNumber), $movedQuestionValues['questionName']);
//    $I->seeInField(QuestionEditPage::questionTextXPath($targetQuestionNumber), $movedQuestionValues['questionText']);
//    $I->seeInField(QuestionEditPage::maxScoreXPath($targetQuestionNumber), $movedQuestionValues['maxScore']);
//
//$I->amGoingTo("See that the former questionNumber 1 is now questionNumber 2.");
//    $targetNewQuestionNumber = $targetQuestionNumber + 1; //i.e., #2
//    $I->seeInField(QuestionEditPage::questionNameXPath($targetNewQuestionNumber), $targetQuestionValues['questionName']);
//    $I->seeInField(QuestionEditPage::questionTextXPath($targetNewQuestionNumber), $targetQuestionValues['questionText']);
//    $I->seeInField(QuestionEditPage::maxScoreXPath($targetNewQuestionNumber), $targetQuestionValues['maxScore']);
//
//
//$I->amGoingTo("See that the question which was questionNumber 2 should now be questionNumber 3");
//    $bumpedQuestionNewNumber = $targetQuestionNumber + 2;
//    $bumpedQuestionValues = $I->getQuestionFieldsInitialValues($examId, $targetQuestionNumber + 1 );
//    $I->seeInField(QuestionEditPage::questionNameXPath($bumpedQuestionNewNumber), $bumpedQuestionValues['questionName']);
//    $I->seeInField(QuestionEditPage::questionTextXPath($bumpedQuestionNewNumber), $bumpedQuestionValues['questionText']);
//    $I->seeInField(QuestionEditPage::maxScoreXPath($bumpedQuestionNewNumber), $bumpedQuestionValue['maxScore']);
//
////Question numbers 4 and 5 should be unchanged.
//
//
//$I->amGoingTo("Submit the form and check that I'm properly redirected");
//    $I->click(QuestionEditPage::$forwardNavButton);
//    $I->seeInCurrentUrl(QuestionEditPage::redirectToUrl($examId, $firstQuestionId));
//
//
//$I->amGoingTo("Go back to the edit page and see the changed questions");
//    $I->amOnPage("exam1/{$examId}/question/edit");
//    $I->seeInTitle(QuestionEditPage::$pageTitleText);
//    $I->see($examName);
//    $I->seeElement(QuestionEditPage::$addQuestionButtonId);
//    //correct navs
//    $I->seeElement(QuestionEditPage::$forwardNavButton);
//    $I->seeElement(QuestionEditPage::$backNavButton);
//    //make sure have expected text given the edits
//    for ( $i = 1; $i <= $numQuestions; $i++ )
//    {
//        switch($i){
//            case $editedQuestionNumber:
//                //check that see expected changes to the edited question
//                $I->seeInField(QuestionEditPage::questionNameXPath($editedQuestionNumber), $prependedText . $v['questionName']);
//                $I->seeInField(QuestionEditPage::questionTextXPath($editedQuestionNumber), $prependedText . $v['questionText']);
//                $I->seeInField(QuestionEditPage::maxScoreXPath($editedQuestionNumber), $newMaxScore);
//                break;
//
//            case in_array($i, $swappedQuestionNumbers):
//                //TODO check for swapped once manipulations have been created
//                break;
//
//            default:
//                $v = $I->getQuestionFieldsInitialValues($examId, $i);
//                $I->seeElement(QuestionEditPage::questionNameXPath($i));
//                $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
//                $I->seeElement(QuestionEditPage::questionTextXPath($i));
//                $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
//                $I->seeElement(QuestionEditPage::maxScoreXPath($i));
//                $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
//        }
//    }
    }
}
<?php
use Page\ElementEditPage;
use Page\QuestionEditPage;

class QuestionAddCest
{
    public $examId = 5;
    public $examName = "TestExam#5 NoQuestions User1";
    public $numQuestions;
    public $testData;

//TODO Do we want to test the case where we skip a question to check for unexpected behavior if the user leaves a question blank?


    public function _before(AcceptanceTester $I)
    {
        //The number of question areas displayed initially. Storing in variable so can update
        $this->numQuestions = QuestionEditPage::$defaultNumberOfQuestions;
        QuestionEditPage::navigateToPage($I, $this->examId);

    }
    public function _after(AcceptanceTester $I)
    {
     
    }

    /**
     *
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function checkPageIntact(AcceptanceTester $I)
    {
        QuestionEditPage::verifyQuestionEditPageIntact($I, $this->examId, $this->examName, $this->numQuestions);
    }

    /**
     *
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function checkAddQuestionButton(AcceptanceTester $I)
    {
        $I->amGoingTo("Add a second question field");
        $I->expect("that a question 2 isn't already present");
        QuestionEditPage::checkQuestionFieldsPresent($I, 2, true);

        $I->amGoingTo("click the add button");
        $I->click(QuestionEditPage::$addQuestionButtonLocator);

        $I->expectTo("see that a second question field is present");
        QuestionEditPage::checkQuestionFieldsPresent($I, 2);
    }

    /**
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function addQuestions(AcceptanceTester $I)
    {
//        $I->amGoingTo("click the add button");
//        $I->click(QuestionEditPage::$addQuestionButtonLocator);
//        $this->numQuestions += 1;

        $I->amGoingTo("Enter text in the question fields");
        $this->testData = $I->generateQuestionTestData($this->numQuestions);
        for ( $i = 1;
              $i <= $this->numQuestions;
              $i++ )
        {
            $I->fillField(['xpath' => QuestionEditPage::questionNameXPath($i)], $this->testData[ $i ]['name']);
            $I->fillField(['xpath' => QuestionEditPage::questionTextXPath($i)], $this->testData[ $i ]['text']);
            $I->fillField(['xpath' => QuestionEditPage::maxScoreXPath($i)], $this->testData[ $i ]['maxScore']);
        }


        $I->amGoingTo("Submit the form and check that I'm properly redirected");
        $I->click(QuestionEditPage::$forwardNavButton);

        $I->expectTo("be on redirected to the element edit page");
        $I->waitForElementVisible(ElementEditPage::$mainBodyLocator);


        $I->amGoingTo("Go back to the edit page and see the changed questions");
        $I->amOnPage("exam1/{$this->examId}/question/edit");
        $I->waitForElement(QuestionEditPage::$mainBodyLocator);

        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            $I->seeInField(['xpath' => QuestionEditPage::questionNameXPath($i)], $this->testData[ $i ]['name']);
            $I->seeInField(['xpath' => QuestionEditPage::questionTextXPath($i)], $this->testData[ $i ]['text']);
            $I->seeInField(['xpath' => QuestionEditPage::maxScoreXPath($i)], $this->testData[ $i ]['maxScore']);
        }
    }

}
<?php
use Page\ElementEditPage;
use Page\ItemCard;
use Page\QuestionEditPage;
use Page\NewSetupPage;

class ItemQuestionAddCest
{
    public $examId = 5;
    public $examName = "TestExam#5 NoQuestions User1";
    public $numQuestions;
    public $testData;

//TODO Do we want to test the case where we skip a question to check for unexpected behavior if the user leaves a question blank?


    public function _before(AcceptanceTester $I)
    {
        //The number of question areas displayed initially. Storing in variable so can update
        $this->numQuestions = 0; // QuestionEditPage::$defaultNumberOfQuestions;
        NewSetupPage::navigateToPage($I);
    }
    public function _after(AcceptanceTester $I)
    {
     
    }

    /**
     * @group item
     * @group setup
     * @group question
     * @param AcceptanceTester $I
     */
    public function checkAddQuestionButton(AcceptanceTester $I)
    {
        $I->amGoingTo("Add a second question field");
        $I->expect("that a question 2 isn't already present");
        $I->dontSeeElement([ItemCard::itemCardLocator(2)]);

        $I->amGoingTo("click the add button");
        $I->click(ItemCard::newItemButtonLocator());

        $I->expectTo("see that a second question field is present");
        $I->seeElement([ItemCard::itemCardLocator(2)]);
    }

    /**
     * @group index
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
            $I->fillField(ItemCard::itemNameFieldLocator($i), $this->testData[ $i ]['name']);
            $I->fillField(ItemCard::itemTextLocator($i), $this->testData[ $i ]['text']);
            $I->fillField(ItemCard::maxScoreLocator($i), $this->testData[ $i ]['maxScore']);
        }
        $I->amGoingTo("Submit the form and check that I'm properly redirected");

        $I->expectTo("be on redirected to the element edit page");


        $I->amGoingTo("Go back to the edit page and see the changed questions");
//        $I->amOnPage("exam/{$this->examId}/question/edit");
//        $I->waitForElement(QuestionEditPage::$mainBodyLocator);
//
//        for ( $i = 1; $i <= $this->numQuestions; $i++ )
//        {
//            $I->seeInField(['xpath' => QuestionEditPage::questionNameXPath($i)], $this->testData[ $i ]['name']);
//            $I->seeInField(['xpath' => QuestionEditPage::questionTextXPath($i)], $this->testData[ $i ]['text']);
//            $I->seeInField(['xpath' => QuestionEditPage::maxScoreXPath($i)], $this->testData[ $i ]['maxScore']);
//        }
    }

}
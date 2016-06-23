<?php


use Page\ElementEditPage;

class ElementsAddCest
{
    public $Faker;


    public $examId = 6;
    public $questionId = 1;
    public $nextQuestionId = 2;
    public $currentRoute;
    public $redirectToRoute;

    public $questionName = 'Question #1 "Exam1Question1"'; //borrowing from exam1

//Storing this in variable so can be updated as needed
    public $numberElements;

    public function _before(AcceptanceTester $I)
    {

        $this->Faker = \Faker\Factory::create();
//        $I->wantTo('Add elements to a question which does not already have them');

        $this->numberElements = ElementEditPage::$defaultNumElements;
        $this->currentRoute = ElementEditPage::route($this->examId, $this->questionId);
        $this->redirectToRoute = ElementEditPage::expectedRedirectRoute($this->examId, $this->questionId);

        $I->test_login($I);
        $I->amOnPage($this->currentRoute);
        $I->wait(2);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function verifyIntact(AcceptanceTester $I)
    {
        ElementEditPage::verifyElementEditPageIntact($I, 1, 1, $this->numberElements);
    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function addSecondElement(AcceptanceTester $I)
    {

        $I->amGoingTo("Add a second element field");
        //check that a subtask 6 isn't already present
        ElementEditPage::checkElementFieldsPresent($I, 2, true);
        //click the add button
        $I->click(ElementEditPage::$addElementButtonId);
//    $I->click(ElementEditPage::$addElementButtonXPath);
        $I->wait(2);
        //check that a second subtask field is present
        ElementEditPage::checkElementFieldsPresent($I, 1);
        ElementEditPage::checkElementFieldsPresent($I, 2);
        $this->numberElements += 1;

    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function enterText(AcceptanceTester $I)
    {

        $I->amGoingTo("Enter text in each element field");
        $testData = $I->generateElementTestData($this->numberElements);
        for ( $i = 1; $i <= $this->numberElements; $i++ )
        {
            $I->fillField(ElementEditPage::elementNameXPath($i), $testData[ $i ]['name']);
            $I->fillField(ElementEditPage::elementTextXPath($i), $testData[ $i ]['text']);


            //open modal and fill in comments
            $I->click(['id' => "btnCustomizeResponse$i"]);
            $I->waitForElementVisible(['id' => "e{$i}area0"]);
//            $I->seeInField(['name' => "e{$i}valence0"], $testData[ $i ]['text']);
            #btnCustomizeResponse1
        }
    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function submitAndCheckRedirection(AcceptanceTester $I)
    {

        $I->amGoingTo("Submit the form and check that I'm properly redirected");
        $I->click(ElementEditPage::$forwardNavButton);
        $I->seeInCurrentUrl($this->redirectToRoute);

    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function checkChangedContent(AcceptanceTester $I)
    {

        $I->amGoingTo("Go back to the edit page and see the changed elements");
        $I->amOnPage($this->currentRoute);
        ElementEditPage::verifyElementEditPageIntact($I, 1, 1, $this->numberElements);
//TODO write check for this

    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     */
    public function checkEverythingDisplays(AcceptanceTester $I)
    {

//$I->amGoingTo("Check that everything is displayed properly");
//    $I->seeInTitle(ElementEditPage::$pageTitleText);
//    $I->see(ElementEditPage::pageHeadingText($examId, $questionId));
//    $I->seeElement(ElementEditPage::$addElementXPath);
//    //correct navs
//    $I->seeElement(ElementEditPage::$forwardNavButton);
//    $I->seeElement(ElementEditPage::$backNavButton);
//    //fields present
//    for ( $i = 1; $i <= ElementEditPage::$defaultNumElements; $i++ )
//    {
//        $I->checkElementFieldsPresent($I, $i);
//    }
//


    }
}

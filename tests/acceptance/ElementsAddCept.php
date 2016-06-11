<?php
use App\Element;
use Page\ElementEditPage;

//@group setup
//@group element

//$scenario->group(['setup', 'element']);

$Faker = Faker\Factory::create();

$I = new AcceptanceTester($scenario);
$I->wantTo('Add elements to a question which does not already have them');

$examId = 6;
$questionId = 1;
$nextQuestionId = 2;
$currentRoute = "/exam/{$examId}/question/{$questionId}/element/edit";
$redirectToRoute = "/exam/{$examId}/question/{$nextQuestionId}/element/edit";

$questionName = 'Question #1 "Exam1Question1"'; //borrowing from exam1

//Storing this in variable so can be updated as needed
$numberElements = ElementEditPage::$defaultNumElements;

$I->test_login($I);
$I->amOnPage($currentRoute);
$I->wait(2);
ElementEditPage::verifyElementEditPageIntact($I, 1, 1, $numberElements);


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
    $numberElements += 1;


$I->amGoingTo("Enter text in each element field");
    $testData = $I->generateElementTestData($numberElements);
    for ( $i = 1; $i <= $numberElements; $i++ )
    {
        $I->fillField(ElementEditPage::elementNameXPath($i), $testData[$i]['name']);
        $I->fillField(ElementEditPage::elementTextXPath($i), $testData[$i]['text']);
        //TODO open modal and fill in comments
    }


$I->amGoingTo("Submit the form and check that I'm properly redirected");
    $I->click(ElementEditPage::$forwardNavButton);
    $I->seeInCurrentUrl($redirectToRoute);


$I->amGoingTo("Go back to the edit page and see the changed elements");
    $I->amOnPage($currentRoute);
ElementEditPage::verifyElementEditPageIntact($I, 1, 1, $numberElements);
//TODO write check for content

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


<?php
use Page\SetupExamSelectPage;

$scenario->group('setup');


$examIdsWhichShouldSee = [1, 2, 4, 5, 6];
$examIdsWhichShouldNotSee = [3]; //belongs to user 2

$editedExamId = 2;
$clonedExamId = 1;
$deletedExamId = 6;

$I = new AcceptanceTester($scenario);
$I->wantTo('Inspect the list of exams on the setup page and make sure the buttons all work');

$I->test_login($I);
$I->wait(2);
$I->amOnPage(SetupExamSelectPage::$URL);

SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);


$I->amGoingTo("Click exam {$editedExamId}'s edit button and check that I am properly redirected");
    $I->click(SetupExamSelectPage::editButtonXPath($editedExamId));
    $I->seeInCurrentUrl("/exam/{$editedExamId}/edit");
    //go back
    $I->amOnPage(SetupExamSelectPage::$URL);
    //make sure nothing changed
    SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);


$I->amGoingTo("Clone an exam");
    $I->click(SetupExamSelectPage::cloneButtonXPath($clonedExamId));
    $I->wait(3);
    $I->see(SetupExamSelectPage::examTerm($clonedExamId));
    $I->see('Clone of "' . SetupExamSelectPage::partialExamName($clonedExamId));


$I->amGoingTo("Start deleting an exam and chicken out by pressing cancel");
    //check modal not shown
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->dontSeeElement("#confirmationModalText");
    //click
    $I->click(SetupExamSelectPage::deleteButtonXPath($deletedExamId));
    //confirm
    $I->wait(2);
    $I->seeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->seeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->seeElement("#confirmationModalText");
// $I->see(SetupExamSelectPage::$deleteExamConfirmationText);
    //confirm deletion
    $I->click(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->wait(1);
    //pop up closed
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->dontSee(SetupExamSelectPage::$deleteExamConfirmationText);
    //check that nothing changed
    SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);


$I->amGoingTo("Delete an exam");
    //check modal not shown
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->dontSeeElement("#confirmationModalText");
    //click
    $I->click(SetupExamSelectPage::deleteButtonXPath($deletedExamId));
    //confirm
    $I->wait(2);
    $I->seeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->seeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->seeElement("#confirmationModalText");
    //$I->see(SetupExamSelectPage::$deleteExamConfirmationText);
    //confirm deletion
    $I->click(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->wait(1);
    //pop up closed
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
    $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
    $I->dontSee(SetupExamSelectPage::$deleteExamConfirmationText);
    //check exam removed
    //TODO Check success message
    //move deleted to other array
    if ( $deletedExamId == array_pop($examIdsWhichShouldSee) )
    {
        $examIdsWhichShouldNotSee[] = $deletedExamId;
        SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);
    } else
    {
        throw Exception("The test assumes that the deleted exam was the last element of the examIdsWhichShouldSee array. This assumption made an ass out of you and the test");
    }


$I->amGoingTo("Click the create new exam button and make sure properly directed");
    $I->click(SetupExamSelectPage::$forwardNavButton);
    $I->seeInCurrentUrl("/exam/create");

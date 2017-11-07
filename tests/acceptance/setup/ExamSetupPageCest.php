<?php
use Page\setup\ExamEditPage;
use Page\setup\SetupExamSelectPage;

class ExamSetupPageCest
{
    public $examIdsWhichShouldSee = [1, 2, 4, 5, 6];
    public $examIdsWhichShouldNotSee = [3]; //belongs to user 2

    public $editedExamId = 2;
    public $clonedExamId = 1;
    public $deletedExamId = 6;



    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Inspect the list of exams on the setup page and make sure the buttons all work');

        SetupExamSelectPage::navigateToPage($I);

    }

    public function _after(AcceptanceTester $I)
    {
    }


    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {

        SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $this->examIdsWhichShouldSee, $this->examIdsWhichShouldNotSee);

    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkRedirectToExamEdit(AcceptanceTester $I)
    {
        $I->amGoingTo("Click exam1 {$this->editedExamId}'s edit button and check that I am properly redirected");
        $I->click(SetupExamSelectPage::editButtonLocator($this->editedExamId));
        
        $I->expectTo("be on the appropriate exam1 edit page");
        $I->waitForElementVisible(ExamEditPage::$mainBodyLocator);
        $I->seeInCurrentUrl("/exam1/{$this->editedExamId}/edit");
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkCloneExam(AcceptanceTester $I)
    {
        $I->wantTo("Clone an exam1");
        $I->click(SetupExamSelectPage::cloneButtonLocator($this->clonedExamId));

        $I->expectTo("see the success message from the server");
        $I->waitForText(SetupExamSelectPage::$cloneExamSuccessMessage);

        $I->expectTo("see the new exam1 in the table");
        $I->see(SetupExamSelectPage::examTerm($this->clonedExamId));
        $I->see('Clone of "' . SetupExamSelectPage::partialExamName($this->clonedExamId));
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function startDeletingExamButCancel(AcceptanceTester $I)
    {
        $I->wantTo("Start deleting an exam1 and chicken out by pressing cancel");

        $I->expect("that the confirmation modal is not visible");
        $I->dontSeeElement(SetupExamSelectPage::$confirmModalLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
        $I->dontSeeElement("#confirmationModalText");

        $I->amGoingTo("click the delete button");
        $I->click(SetupExamSelectPage::deleteButtonXPath($this->deletedExamId));
        $I->waitForElementVisible(SetupExamSelectPage::$confirmModalLocator);

        $I->expectTo("see the components of the modal");
        $I->seeElement(SetupExamSelectPage::$deleteCancelButtonLocator);
        $I->seeElement(SetupExamSelectPage::$deleteConfirmButtonLocator);
        $I->seeElement(SetupExamSelectPage::$deleteExamConfirmTextLocator);


        $I->amGoingTo("cancel deletion. ");
        $I->click(SetupExamSelectPage::$deleteCancelButtonLocator);
        $I->waitForElementNotVisible(SetupExamSelectPage::$confirmModalLocator);

        $I->expect("that the modal is closed and no longer visible");
        $I->dontSeeElement(SetupExamSelectPage::$deleteCancelButtonLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteConfirmButtonLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmTextLocator);
        $I->dontSee(SetupExamSelectPage::$deleteExamConfirmationText);

        SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $this->examIdsWhichShouldSee, $this->examIdsWhichShouldNotSee);

    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     * @throws
     */
    public function checkDeleteExam(AcceptanceTester $I)
    {
        $I->wantTo("Delete an exam1");

        $I->expect("that the confirmation modal is not visible");
        $I->dontSeeElement(SetupExamSelectPage::$confirmModalLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamCancelButtonXPath);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmButtonXPath);
        $I->dontSeeElement("#confirmationModalText");

        $I->amGoingTo("click the delete button");
        $I->click(SetupExamSelectPage::deleteButtonXPath($this->deletedExamId));
        $I->waitForElementVisible(SetupExamSelectPage::$confirmModalLocator);

        $I->expectTo("see the components of the modal");
        $I->seeElement(SetupExamSelectPage::$deleteCancelButtonLocator);
        $I->seeElement(SetupExamSelectPage::$deleteConfirmButtonLocator);
        $I->seeElement(SetupExamSelectPage::$deleteExamConfirmTextLocator);

        $I->amGoingTo("confirm deletion. ");
        $I->click(SetupExamSelectPage::$deleteConfirmButtonLocator);
        $I->waitForElementNotVisible(SetupExamSelectPage::$confirmModalLocator);

        $I->expect("that the modal is closed and no longer visible");
        $I->dontSeeElement(SetupExamSelectPage::$deleteCancelButtonLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteConfirmButtonLocator);
        $I->dontSeeElement(SetupExamSelectPage::$deleteExamConfirmTextLocator);
        $I->dontSee(SetupExamSelectPage::$deleteExamConfirmationText);

        $I->expectTo('see the success message from the server');
        $I->see(SetupExamSelectPage::$deleteExamSuccessMessage);

        //move deleted to other array
        if ( $this->deletedExamId == array_pop($this->examIdsWhichShouldSee) )
        {
            $this->examIdsWhichShouldNotSee[] = $this->deletedExamId;
            SetupExamSelectPage::verifySetupExamSelectPageIntact($I, $this->examIdsWhichShouldSee, $this->examIdsWhichShouldNotSee);
        } else
        {
            throw Exception("The test assumes that the deleted exam1 was the last element of the examIdsWhichShouldSee array. This assumption made an ass out of you and the test");
        }

    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkCreateNewExam(AcceptanceTester $I)
    {
        $I->amGoingTo("Click the create new exam1 button and make sure properly directed");
        $I->click(SetupExamSelectPage::$forwardNavButton);
        $I->seeInCurrentUrl("/exam1/create");

    }

}

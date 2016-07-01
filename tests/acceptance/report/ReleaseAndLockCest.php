<?php
use Page\BootboxModals;
use Page\report\ReportIndexPage;

class ReleaseAndLockCest
{
public $numberOfExams = 5;
public 
    $examIdsToSkip = [3]; //belongs to another user

    
public $toReleaseExamId = 1; //has graded students
public 
    $cannotReleaseExamId = 2;//will not be able to be released


    public function _before(AcceptanceTester $I)
    {
        $I->wantTo("Make sure that the /report page behaves correctly for releasing and locking an exam. (Other /report actions are handled separately)");
        ReportIndexPage::navigateToReportIndexPage($I);
    }

    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        ReportIndexPage::verifyPageIntact($I, $this->numberOfExams, $this->examIdsToSkip);        
    }


    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function checkSomeNotReleased(AcceptanceTester $I)
    {
        $I->amGoingTo("Check that all exams are not released");
        for ($i = 1;
             $i <= $this->numberOfExams;
             $i++)
        {
            if (! in_array($i, $this->examIdsToSkip))
            {
                ReportIndexPage::checkExamReleased($I, $i);
            }
        }
        
    }

    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function clickReleaseAndCancel(AcceptanceTester $I)
    {
        $I->wantTo("Click the release button, see the confirm modal, click cancel, and see that nothing changed");
        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        BootboxModals::waitForBootboxModal($I, true);
        $I->seeElement(['css' => '.modal-content .modal-body .' . ReportIndexPage::$releaseTextClass]);

        $I->amGoingTo("click the cancel button in the modal and see the modal disappear");
        $I->click(BootboxModals::bootboxCancelButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that nothing has changed");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId);
        
}

    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function releaseExam(AcceptanceTester $I)
    {
        $I->wantTo("release an exam and see the expected messages and page changes");
        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        BootboxModals::waitForBootboxModal($I, true);
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(BootboxModals::bootboxConfirmButtonLocator());
        $I->waitForElementNotVisible('/html/body/div[7]/div/div/div[1]/div/p[1]');

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->wait(3);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseSuccessTextClass]);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for exam {$this->toReleaseExamId} has changed state");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId, true);
        
    }

    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function hideExam(AcceptanceTester $I)
    {
        $I->wantTo("hide the exam which I just released and verify that it is no longer released");
        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        BootboxModals::waitForBootboxModal($I, true);
//verify correct message
        $I->seeElement(['css' => '.' . ReportIndexPage::$hideTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(BootboxModals::bootboxConfirmButtonLocator());
        $I->waitForElementNotVisible('/html/body/div[7]/div/div/div[1]/div/p[1]');
        $I->wait(3);

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());
        $I->seeElement(['css' => '.' . ReportIndexPage::$hideSuccessTextClass]);
//    $I->see(ReportIndexPage::$hideSuccessText);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for exam {$this->toReleaseExamId} has back to the unreleased state");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId);


    }

    /**
     * @group curr_dev
     * @group report
     * @group feedback
     * @param AcceptanceTester $I
     */
    public function reReleaseExam(AcceptanceTester $I)
    {
        $I->wantTo("re-release the exam which I just released and verify that get the appropriate message");
        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        BootboxModals::waitForBootboxModal($I, true);
        $I->wait(3);
//verify correct message
        $I->seeElement(['css' => '.' . ReportIndexPage::$reReleaseTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(BootboxModals::bootboxConfirmButtonLocator());
        $I->waitForElementNotVisible('/html/body/div[7]/div/div/div[1]/div/p[1]');
        $I->wait(3);

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->wait(2);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());
//verify correct message
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseSuccessTextClass]);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for exam {$this->toReleaseExamId} has back to the unreleased state");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId);

    }

}
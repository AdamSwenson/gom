<?php
use App\Exam;
use Page\BootboxModals;
use Page\report\ReportIndexPage;

class ReleaseAndLockCest
{
    public $numberOfExams = 5;
    public $examIdsToSkip = [3]; //belongs to another user

    public $toReleaseExamId = 1; //has graded students
    public $cannotReleaseExamId = 2;//will not be able to be released

    public $toHideExamId = 7;
    public $toReReleaseExamId = 8;

    public function _before(AcceptanceTester $I)
    {
//        $this->toHideExamId = $I->haveRecord('exams', ['user_id' => 1, 'term' => 'dfljdfljdf',
//                                           'year' => 2015, 'released' => 1]);

        $I->wantTo("Make sure that the /report page behaves correctly for releasing and locking an exam1. (Other /report actions are handled separately)");
        ReportIndexPage::navigateToReportIndexPage($I);
    }

    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        ReportIndexPage::verifyPageIntact($I, $this->numberOfExams, $this->examIdsToSkip);
    }


    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function checkSomeNotReleased(AcceptanceTester $I)
    {
        $I->amGoingTo("Check that all exams are not released");
        for ( $i = 1;
              $i <= $this->numberOfExams;
              $i++ )
        {
            if ( ! in_array($i, $this->examIdsToSkip) )
            {
                ReportIndexPage::checkExamReleased($I, $i);
            }
        }

    }

    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function clickReleaseAndCancel(AcceptanceTester $I)
    {
        $I->wantTo("Click the release button, see the confirm modal, click cancel, and see that nothing changed");

        $I->amGoingTo("Click the release button and check that see confirmation message");

        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        $I->waitForElementVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the modal components");
        $I->seeElement(ReportIndexPage::$releaseConfirmButtonLocator);
        $I->seeElement(ReportIndexPage::$releaseCancelButtonLocator);

        $I->expectTo("see the correct confirmation message (by checking the class of the text)");
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseTextClass]);

        $I->amGoingTo("click the cancel button in the modal and see the modal disappear");
        $I->click(ReportIndexPage::$releaseCancelButtonLocator);
        $I->waitForElementNotVisible(ReportIndexPage::$confirmationModalLocator);
        
        $I->expectTo("see that nothing has changed");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId);

    }

    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function releaseExam(AcceptanceTester $I)
    {
        $I->wantTo("release an exam1 and see the expected messages and page changes");

        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReleaseExamId));
        $I->waitForElementVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the modal components");
        $I->seeElement(ReportIndexPage::$releaseConfirmButtonLocator);
        $I->seeElement(ReportIndexPage::$releaseCancelButtonLocator);

        $I->expectTo("see the correct confirmation message (by checking the class of the text)");
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(ReportIndexPage::$releaseConfirmButtonLocator);
        $I->waitForElementNotVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->wait(3);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseSuccessTextClass]);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for the exam1 has changed state");
        ReportIndexPage::checkExamReleased($I, $this->toReleaseExamId, true);

    }

    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function hideExam(AcceptanceTester $I)
    {
        $I->wantTo("hide the exam1 which I just released and verify that it is no longer released");

        $I->amOnPage(ReportIndexPage::$URL);
        $I->waitForElementVisible(ReportIndexPage::$mainBodyLocator);

        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toHideExamId));
        $I->waitForElementVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the correct confirmation message (by checking the class of the text)");
        $I->seeElement(['css' => '.' . ReportIndexPage::$hideTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(ReportIndexPage::$hideConfirmButtonLocator);
        $I->waitForElementNotVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());
        $I->seeElement(['css' => '.' . ReportIndexPage::$hideSuccessTextClass]);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for exam1 is back to the unreleased state");
        ReportIndexPage::checkExamReleased($I, $this->toHideExamId);

    }

    /**
     * @group report
     * @group feedback
     * @group exam_release
     * @param AcceptanceTester $I
     */
    public function reReleaseExam(AcceptanceTester $I)
    {
        $I->wantTo("re-release the exam1 which I just released and verify that get the appropriate message");
        $I->amGoingTo("Click the release button and check that see confirmation message");
        $I->click(ReportIndexPage::releaseToggleLocator($this->toReReleaseExamId));
        $I->waitForElementVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the correct confirmation message");
        $I->seeElement(['css' => '.' . ReportIndexPage::$reReleaseTextClass]);

        $I->amGoingTo("click the confirm button in the modal and see the modal disappear");
        $I->click(ReportIndexPage::$releaseConfirmButtonLocator);
         $I->waitForElementNotVisible(ReportIndexPage::$confirmationModalLocator);

        $I->expectTo("see the success message in a modal once the ajax call has completed");
        BootboxModals::waitForBootboxModal($I);
        $I->wait(2);
        $I->seeElement(BootboxModals::bootboxAlertOkButtonLocator());

        $I->expectTo("see the expected message");
        $I->seeElement(['css' => '.' . ReportIndexPage::$releaseSuccessTextClass]);

        $I->expect("the success message to disappear when I click ok in the alert");
        $I->click(BootboxModals::bootboxAlertOkButtonLocator());
        BootboxModals::waitForBootboxModal($I, true, true);

        $I->expectTo("see that the toggle for exam1 is back to the unreleased state");
        ReportIndexPage::checkExamReleased($I, $this->toReReleaseExamId);

    }

}
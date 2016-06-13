<?php


use Page\grade\DashboardArea;
use Page\grade\GradingPage;
use Page\grade\RosterArea;

/**
 * Class DashboardCest
 * @group('grade')
 */
class DashboardCest
{
    public $examId = 2;

    public $studentRowId = 1;
    public $numQuestions = 5;
    public $numElements = 5;

    public $numberStudents = 5;
    public $previouslyGradedExams = 0;

    public function _before(AcceptanceTester $I)
    {
        GradingPage::navigateToGradingPage($I, $this->examId);

//        $I->test_login($I);
//        $I->amOnPage(GradingPage::route($this->examId));
//        $I->wait(1);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function checkIntact(AcceptanceTester $I)
    {
        DashboardArea::assertDashboardIntact($I);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function checkInitialExamStatsValues($I)
    {
        $I->amGoingTo("Check the values of the exam stats");
        $numRemaining = $this->numberStudents - $this->previouslyGradedExams;
        DashboardArea::assertExamStatsHasValues($I, $this->previouslyGradedExams, $numRemaining);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function checkInitialTimeStatsValues(AcceptanceTester $I)
    {
        $I->amGoingTo("check the values of the time stats");
        $initialTimeShort = '00:00';
        $initialTimeLong = '00:00:00';
        DashboardArea::assertTimeStatsHasValues($I, $initialTimeShort, $initialTimeShort, $initialTimeShort, $initialTimeShort);
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function seeDashboardChangesWhenSelectStudent(AcceptanceTester $I)
    {

        $examId = 2;
        $numQuestions = 5;

        $I->amGoingTo("Click the student row {$this->studentRowId} and check that see expected dashboard changes happen  (other page components are checked elsewhere)");
        $I->dontSeeElement(['id' => 'questionPanel']);

        for ( $i = 1; $i <= $numQuestions; $i++ )
        {
            $I->expectTo("not see the question tab for q{$i}");
            $I->dontSee("Q{$i}");
            $I->dontSeeElement(GradingPage::questionPanelTabXPath($i));
        }

        $I->click(['css' => '#studentListItem0']);
        $I->wait(1);

        $I->expectTo("see that the question fields have displayed");
        $I->see('Question #1: "Exam' . $examId . 'Question1"');
        for ( $i = 1; $i <= $numQuestions; $i++ )
        {
            $I->expectTo("see the question tab for q{$i}");
            $I->see("Q{$i}");
            $I->seeElement(GradingPage::questionPanelTabXPath($i));
        }

        $I->expect("the timer button to be active");
        DashboardArea::assertTimerButtonActive($I);

        $I->expect("the time counters to no longer have their initial values");
        $I->wait(1);
        DashboardArea::assertInitialValuesPresent($I, true);
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function pauseTimer(AcceptanceTester $I)
    {
        $I->expect("the timer to be running after I select a student");
        GradingPage::clickStudentRow($I, 3);
        DashboardArea::assertTimerButtonActive($I);

        $total = $I->grabTextFrom(DashboardArea::$totalTimeLocator);
        $current = $I->grabTextFrom(DashboardArea::$currentExamTimeLocator);
        $remaining = $I->grabTextFrom(DashboardArea::$remainingTimeLocator);

        //pause
        $I->amGoingTo("press the pause button on the timer");
        $I->click(DashboardArea::$timerButtonLocator);
        $I->wait(2);
        DashboardArea::assertTimerButtonPaused($I);

        $I->amGoingTo("wait briefly then start the timer again");


        //un-pause
        $I->click(DashboardArea::$timerButtonLocator);
        DashboardArea::assertTimerButtonActive($I);
        //let run again
        $I->wait(10);
        $I->amGoingTo("check that the times have increased");
        $newTotal = $I->grabTextFrom(DashboardArea::$totalTimeLocator);
        $newCurrent = $I->grabTextFrom(DashboardArea::$currentExamTimeLocator);
        $newRemaining = $I->grabTextFrom(DashboardArea::$remainingTimeLocator);

        $I->assertNotEquals($total, $newTotal);
        $I->assertNotEquals($current, $newCurrent);
        $I->assertNotEquals($remaining, $newRemaining);

//        codecept_debug([$newTotal, $newRemaining, $newCurrent]);
        //todo test that doesn't do stuff if no student active
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     * @incomplete
     */
    public function checkStats(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     */
    public function checkThatNumberGradedUpdates(AcceptanceTester $I){
        $I->expectTo("see that no exams have been graded");
        DashboardArea::assertExamStatsHasValues($I, 0, $this->numberStudents);

        $I->amGoingTo("enter a grade for one student so that will now be marked as graded");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->fillField(GradingPage::questionScoreFieldLocator(1), 92);
        GradingPage::clickQuestionTab($I, 2);

        $I->expectTo("see the number graded field updated ");
        DashboardArea::assertExamStatsHasValues($I, 1, $this->numberStudents - 1);

        $I->expectTo("see the number graded field has the new value when the page is reloaded ");
        $I->reloadPage();
        $I->wait(3);
        DashboardArea::assertExamStatsHasValues($I, 1, $this->numberStudents - 1);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group dashboard
     * 
     */
    public function checkThatSaveAndFinishButtonAppears(AcceptanceTester $I, $scenario){
        $scenario->incomplete();

        
        $I->expect("that the finished button is not showing");
        $I->dontSeeElement(DashboardArea::$finishButtonLocator);
        $I->dontSee(DashboardArea::$finishButtonText, DashboardArea::$finishButtonLocator);

        $I->amGoingTo("give each student a grade on one question and check that the finished button appears");
        for($i=0; $i<$this->numberStudents; $i++){
                $I->amGoingTo('enter a question score for a previously ungraded student ');
                RosterArea::assertRowIsMarkedGraded($I, $i, true);
                GradingPage::clickStudentRow($I, $i);
            GradingPage::clickQuestionTab($I, 1);
                $I->fillField(GradingPage::questionScoreFieldLocator(1), 92);
            GradingPage::clickQuestionTab($I, 3);

                $I->amGoingTo("select another student");
                $next = $i == $this->numberStudents -1 ? 0 : $i + 1;
                GradingPage::clickStudentRow($I, $next);

            //$I->wait(2);
        }

        $I->expect("that the finished button is showing");
        $I->seeElement(DashboardArea::$finishButtonLocator);
        $I->see(DashboardArea::$finishButtonText, DashboardArea::$finishButtonLocator);
    }

}

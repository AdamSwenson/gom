<?php


use Page\grade\DashboardArea;
use Page\grade\GradingPage;

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
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     * @group('grade')
     */
    public function logIn(AcceptanceTester $I)
    {
        $I->test_login($I);
        $I->amOnPage(GradingPage::route($this->examId));
        $I->wait(1);
    }

    /*
     * @group('grade')
     */
    public function checkIntact(AcceptanceTester $I)
    {
//        $I->waitForJS("return typeof jQuery != 'undefined';", 60);
//        $I->amGoingTo('dance');
//        $I->waitForJS("return typeof $ == 'undefined';", 60);
        //whole page
        GradingPage::verifyGradingPageIntact($I, $this->examId);

        DashboardArea::assertDashboardIntact($I);
    }

    /**
     * @param $I
     * @group('grade')
     */
    public function checkInitialExamStatsValues($I)
    {
        $I->amGoingTo("Check the values of the exam stats");
        $numRemaining = $this->numberStudents - $this->previouslyGradedExams;
        DashboardArea::assertExamStatsHasValues($I, $this->previouslyGradedExams, $numRemaining);
    }

    /**
     * @param AcceptanceTester $I
     * @group('grade')
     */
    public function checkInitialTimeStatsValues(AcceptanceTester $I)
    {
        $I->amGoingTo("check the values of the time stats");
        $initialTimeShort = '00:00';
        $initialTimeLong = '00:00:00';
        DashboardArea::assertTimeStatsHasValues($I, $initialTimeShort, $initialTimeShort, $initialTimeLong, $initialTimeLong);
    }


    /**
     * @param AcceptanceTester $I
     * @group('grade')
     */
    public function clickStudent(AcceptanceTester $I)
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
        $initialTime = '00:00';
        DashboardArea::assertTimeStatsHasValues($I, $initialTime, $initialTime, $initialTime, $initialTime);
    }


    /**
     * @param AcceptanceTester $I
     * @group('grade')
     */
    public function pauseTimer(AcceptanceTester $I)
    {
        //student area should be showing in initial state
        DashboardArea::assertTimerButtonActive($I);

        $total = $I->grabTextFrom(DashboardArea::$totalTimeLocator);
        $current = $I->grabTextFrom(DashboardArea::$currentExamTimeLocator);
        $remaining = $I->grabTextFrom(DashboardArea::$remainingExamsLocator);

        //un-pause
        $I->click(DashboardArea::$timerButtonLocator);
        $I->wait(1);
        DashboardArea::assertTimerButtonActive($I);
        //let run again
        $I->wait(2);
        //pause
        $I->click(DashboardArea::$timerButtonLocator);
        DashboardArea::assertTimerButtonPaused($I);



        //check timer says runningTimer: toggle
        //on to off; off to on

        //todo test that doesn't do stuff if no student active
    }

    /**
     * @param AcceptanceTester $I
     * @group('grade')
     */
    public function checkStats(AcceptanceTester $I)
    {
    }

}

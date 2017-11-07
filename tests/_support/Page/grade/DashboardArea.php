<?php
namespace Page\grade;

/**
 * Properties of the dashboard area of the grading page
 * Class DashboardArea
 * @package Page\grade
 */
class DashboardArea
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $initialTimeValue = '00:00';

    //timer button
    public static $timerButtonLocator = ['id' => 'btnTimer'];
    public static $timerRunningText = 'Running';
    public static $timerRunningClass = 'btn-success';
    public static $timerPausedText = 'Paused';
    public static $timerPausedClass = 'btn-warning';

    //number exams display
    public static $gradedExamsLocator = ['id' => 'graded'];
    public static $remainingExamsLocator = ['id' => 'remaining'];

    //time stats display
    public static $avgTimeLocator = ['id' => 'avgTime'];
    public static $totalTimeLocator = ['id' => 'totalTime'];
    public static $remainingTimeLocator = ['id' => 'timeRemaining'];
    public static $currentExamTimeLocator = ['id' => 'thisExamTime'];

    //save and finish button
    public static $finishButtonLocator = ['id' => 'finishButton'];
    public static $finishButtonText = 'Save & Finish';

    
    /* ------------------------------------ Assertions ------------------------------ */
    public static function assertTimerButtonPaused($I)
    {
        $I->expectTo("see the timer button in its paused state");
        $I->seeElement(self::$timerButtonLocator, ['class' => 'btn ' . self::$timerPausedClass]);
        $I->see(self::$timerPausedText, self::$timerButtonLocator);
    }

    public static function assertTimerButtonActive($I)
    {
        $I->expectTo("see the timer button in its active state");
        $I->seeElement(self::$timerButtonLocator, ['class' => 'btn ' . self::$timerRunningClass]);
        $I->see(self::$timerRunningText, self::$timerButtonLocator);
    }

    /**
     * Checks the specified values.
     * Not = true can be used to check that have changed from initial values
     * (where don't have precise number)
     * @param $I
     * @param $currentExamTime
     * @param $averageExamTime
     * @param $totalGradingTime
     * @param $remainingGradingTime
     * @param bool $not
     */
    public static function assertTimeStatsHasValues($I, $currentExamTime, $averageExamTime, $totalGradingTime, $remainingGradingTime, $not = false)
    {
        if ( ! $not )
        {
            $I->expectTo("see the correct current exam1's grading time");
            $I->see($currentExamTime, self::$currentExamTimeLocator);

            $I->expectTo("see the correct average exam1 grading time");
            $I->see($averageExamTime, self::$avgTimeLocator);

            $I->expectTo("see the correct total time");
            $I->see($totalGradingTime, self::$totalTimeLocator);

            $I->expectTo("see the correct remaining time");
            $I->see($remainingGradingTime, self::$remainingTimeLocator);
        } else
        {
            $I->expectTo("see the correct current exam1's grading time");
            $I->dontSee($currentExamTime, self::$currentExamTimeLocator);

            $I->expectTo("see the correct average exam1 grading time");
            $I->dontSee($averageExamTime, self::$avgTimeLocator);

            $I->expectTo("see the correct total time");
            $I->dontSee($totalGradingTime, self::$totalTimeLocator);

            $I->expectTo("see the correct remaining time");
            $I->dontSee($remainingGradingTime, self::$remainingTimeLocator);
        }
    }

    public static function assertExamStatsHasValues($I, $numberGraded, $remainingExams)
    {
        $I->expectTo("see the correct number of graded exams");
        $I->see($numberGraded, self::$gradedExamsLocator);

        $I->expectTo("see the correct number of remaining exams");
        $I->see($remainingExams, self::$remainingExamsLocator);
    }

    /**
     * Checks that elements are present in the state expected
     * on page load.
     * @param AcceptanceTester $I
     */
    public static function assertDashboardIntact($I)
    {
        $I->wantTo("see all the components of the grading dashboard on the page");
        DashboardArea::assertTimerButtonPaused($I);

        $I->expectTo("see the time stats area");
        $I->seeElement(DashboardArea::$currentExamTimeLocator);
        $I->seeElement(DashboardArea::$avgTimeLocator);
        $I->seeElement(DashboardArea::$totalTimeLocator);
        $I->seeElement(DashboardArea::$remainingTimeLocator);

        $I->expectTo("see the exam1 stats area ");
        $I->seeElement(DashboardArea::$gradedExamsLocator);
        $I->seeElement(DashboardArea::$remainingExamsLocator);
    }

    public static function assertInitialValuesPresent($I, $not=false)
    {
        self::assertTimeStatsHasValues($I, self::$initialTimeValue, self::$initialTimeValue, self::$initialTimeValue, self::$initialTimeValue, $not);
    }
    
}

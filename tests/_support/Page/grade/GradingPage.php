<?php
namespace Page\grade;

class GradingPage
{
    // include url of current page
    public static $URL = '/grade/exam/';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $pageTitleText = "Grade Exam | gradeomatic";
    public static $pageSubHeadingText = "Select a student to begin grading";

    //active student fields (also typeahead)
    public static $activeStudentNameFieldXPath = "//*[@id='activeStudentName']";
    public static $activeStudentNameFieldDefaultText = "No Student Selected";
    public static $activeStudentIdFieldXPath = "//*[@id='activeStudentIdentifier']";
    public static $activeStudentIdFieldDefaultText = "--";

    //buttons
    public static $finishButtonXPath = "//*[@id='finishButton']";
    public static $finishButtonText = "Save & Finish";
    public static $timerButtonXPath = "//*[@id='btnTimer']";

    //top stats
    public static $numberGradedXPath = "";
    public static $numberRemainingXPath = "";

    //students table
    public static $studentsTableXPath = "//*[@id='studentRoster']";

    //stats fields
    public static $gradingStatsPanelXPath = "//*[@id='gradingStatsPanel']";
    public static $currentExamTimeXPath = "//*[@id='thisExamTime']";
    public static $averageExamTimeXPath = "//*[@id='avgTime']";
    public static $totalExamTimeXPath = "//*[@id='totalTime']";
    public static $remainingExamTimeXPath = "//*[@id='remainingExamTime']";

    public static $nameVisibilityButtonXPath = "//*[@id='nameVisibilityControl']";


    public static $sliderValenceLabels = ['Missing', 'Poor', 'Fair', 'Excellent'];


    /**
     * Returns x path to the tab for selecting a question
     * @param $questionNumber
     * @return string
     */
    public static function questionPanelTabXPath($questionNumber){
        return "//*[@id='tabQuestion{$questionNumber}']";
    }

    public static function elementAreaXPath($questionNumber, $elementNumber){
        return "//*[@id='element{$elementNumber}']";
//        return "//*[@id='Q{$questionNumber}E{$elementNumber}']";

    }
    
    public static function sliderXPath($questionNumber, $subtask){
        return "//*[@id='sliderQ{$questionNumber}E{$subtask}']";
    }

    public static function commentXPath($questionNumber, $subtask){
        return "//*[@id='commentQ{$questionNumber}E{$subtask}']";
    }
    
    public static function pageHeadingText($term, $year, $examName){
       return <<<TAG
        {$term}, {$year} "$examName"
TAG;
    }

    /* ----------- Question score field ----------*/
    public static function questionScoreFieldXPath($questionNumber){
        return "//*[@id='questionScore{$questionNumber}']";
    }


    /* ----------- Letter grade button -----------*/
    public static $letterGradeButtonContainerXPath = "//*[@id='letterGradeArea']";
    public static $letterGradeButtonText = "Letter grade";
    public static $letterGradeListXPath = "//*[@id='letterGradeList']";
    /**
     * Returns the xpath to the label of the button
     * @param $questionNumber
     * @return string
     */
    public static function letterGradeButtonLabelXPath($questionNumber){
        return "//*[@id='letterGradeForQuestion{$questionNumber}']";
    }

    /**
     * Returns the xpath to the button itself
     * @param $questionNumber
     * @return string
     */
    public static function letterGradeButtonXPath($questionNumber){
        return "//*[@id='letterGradeButton{$questionNumber}']";
    }
    /* ----------------------*/


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
    
    
    /* ----------------- Testing ---------- */
public static function verifyGradingPageIntact($I, $examId){
    $I->amGoingTo("Check that all fields and default text are present");
    $I->seeInCurrentUrl(self::route($examId));
    $I->seeInTitle(self::$pageTitleText);
    $I->see(self::$pageSubHeadingText);

    $I->seeElement(self::$studentsTableXPath);
    $I->seeElement(self::$gradingStatsPanelXPath);
    //$I->see(self::$finishButtonText);

    //active student fields
    $I->seeElement(self::$activeStudentIdFieldXPath);
    //$I->seeInField(self::$activeStudentIdFieldXPath, self::$activeStudentIdFieldDefaultText);
    $I->seeElement(self::$activeStudentNameFieldXPath);
    //$I->seeInField(self::$activeStudentNameFieldXPath, self::$activeStudentNameFieldDefaultText);
}


    public static function clickStudentRow($I, $rowId){
        $I->amGoingTo("Click on row {$rowId} and check that the questions field displays");
        $I->seeElement(['id' => 'studentListItem0']);
//$I->executeJS("$('#studentListItem0').triggerHandler('click');");
        $I->click(['id' => 'studentListItem0']);
        $I->wait(2);
        $I->seeElement(['id' => 'questionPanel']);
    }

}
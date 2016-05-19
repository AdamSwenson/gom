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


    public static $letterGradeListId = "letterGradeList";

    /** @var string The text that should see if there are no elements associated */
    public static $noElementsText = "No elements for this question";


    public static function sliderContainerLocator($questionNumber, $subtask){
        return ['css' => "#element{$subtask} > div > span.col-lg-5.sliderContainer.Q{$questionNumber}E{$subtask}"];
    }



    /* --------------------------- Dashboard ----------------------- */
    public static function numberGradedLocator(){
        return ["css" => "#graded"];
    }

    public static function numberRemainingLocator(){
        return ["css" => "#remaining"];
    }


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
        $I->seeElement(['css' => "#studentListItem{$rowId}"]);
//        $I->click(['css' => "#studentListItem{$rowId}"]);
        $I->click("//*[@id=\"studentListItem{$rowId}\"]");
        $I->click(['css' => "html body div.container-fluid div.row div.col-md-4.rosterAndDashboardColumn div.panel.panel-default table#studentRoster.table.table-fixed.table-hover tbody#studentRosterBody tr#studentListItem0"]);
        
        /*        "html body div.container-fluid div.row div.col-md-4.rosterAndDashboardColumn div.panel.panel-default table#studentRoster.table.table-fixed.table-hover tbody#studentRosterBody tr#studentListItem0 td#studentName0.col-xs-6"*/
//        $I->waitForElementVisible(['css' => "#panelQuestion{$rowId}"]);
      //  $I->waitForElementVisible(['css' => "#questionArea"]);
//        $I->seeElement(['id' => 'questionPanel']);
    }

    /**
     * Clicks on the specified question tab.
     * First checks that the tab is hidden. Then checks
     * that the tab is displayed.
     * @param $I
     * @param $questionNumber
     */
    public static function clickQuestionTab($I, $questionNumber){
        $I->expectTo("not see the question panel for question $ {$questionNumber}");
        $I->dontSeeElement(['css' => "#panelQuestion{$questionNumber}"]);

        $I->amGoingTo("click the tab for question #{$questionNumber}");
        $I->click(self::questionPanelTabXPath($questionNumber));
        $I->waitForElementVisible(['css' => "#panelQuestion{$questionNumber}"]);

        $I->expectTo("not see the question panel for question $ {$questionNumber}");
        $I->seeElement(['css' => "#panelQuestion{$questionNumber}"]);
    }

    /**
     * Tests to make sure all expected items are present in the
     * specified panel.
     * @param $I
     * @param $questionNumber
     * @param $numElements
     */
    public static function verifyQuestionPanelIntact($I, $questionNumber, $numElements){
        
        $I->expectTo("see that the letter grade button and question score field are present");
        $I->seeElement(self::letterGradeButtonLabelXPath($questionNumber));
        $I->seeElement(self::letterGradeButtonXPath($questionNumber));
        $I->see(self::$letterGradeButtonText);
        $I->seeElement(self::questionScoreFieldXPath($questionNumber));

        $I->amGoingTo("Check that the element fields for question {$questionNumber} are displayed properly");
        for ( $j = 1; $j <= $numElements; $j++ )
        {
            $I->expectTo("see the div for element Q{$questionNumber}E{$j}");
            $I->seeElement(self::elementAreaXPath($questionNumber, $j));
            $I->expectTo("see the common part of the element name ");
            $I->see("Element #{$j}: ");
            //todo expected element nameself::
            $I->expectTo("see the comment area for Q{$questionNumber}E{$j}");
            $I->seeElement(self::commentXPath($questionNumber, $j));
        }

        $I->amGoingTo("Check that the sliders for question {$questionNumber} are displayed properly");

        $I->waitForElementVisible(self::sliderContainerLocator($questionNumber, 1));

        for ( $j = 1; $j <= $numElements; $j++ )
        {
            $I->amGoingTo("Inspect the slider parts for Q{$questionNumber}E{$j}");
            $I->expectTo("see the slider container span");
            $I->seeElement(self::sliderContainerLocator($questionNumber, $j));

            $I->expect("that the original input will be hidden and replaced with the bootstrap slider");
//            $I->dontSeeElement(self::sliderXPath($questionNumber, $j));
            $I->seeElementInDOM(self::sliderXPath($questionNumber, $j));

            $I->expect("The valence labels will be visible. ");
            $k = 1;
            foreach ( self::$sliderValenceLabels as $v )
            {

                //$I->see($v); //, "#Q{$i}E{$j}");
                $I->see($v, ['css' => "#element{$j} > div > span.col-lg-5.sliderContainer.Q{$questionNumber}E{$j} > div > div.slider-tick-label-container > div:nth-child($k)"]);
                $k++;
                #element1 > div > span.col-lg-5.sliderContainer.Q1E1 > div > div.slider-tick-label-container > div:nth-child(1)
            }
        }
    }


}
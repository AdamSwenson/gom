<?php
namespace Page\grade;

/**
 * Class GradingPage
 *
 * TODO Refactor to use LetterGradeButtonArea for locations
 * TODO Refactor to use DashboardArea for locations
 *
 * @package Page\grade
 */
class GradingPage
{
    // include url of current page
    public static $URL = '/grade/exam/';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    #common
    public static $pageTitleText = "Grade Exam | gradeomatic";
    public static $pageSubHeadingText = "Select a student to begin grading";
    public static $mainBodyLocator = ['id' => 'gradeExamPage'];

    public static $questionPanelLocator =  ['id' => 'questionPanel'];

    //active student fields (also typeahead)
    public static $activeStudentNameFieldLocator = ["id" => 'activeStudentName'];
    public static $activeStudentNameFieldDefaultText = "No Student Selected";
    public static $activeStudentIdFieldLocator = ["id" => 'activeStudentIdentifier'];
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

    public static $rosterAndDashboardColumnLocator = ['id' => 'rosterAndDashboardColumn'];
    public static $questionAndSliderColumnLocator = ['id' => 'questionAndSliderColumn'];


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
    public static function questionPanelTabLocator($questionNumber){
        return ['id'=>"tabQuestion{$questionNumber}"];
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

    public static function commentFieldLocator($questionNumber, $subtask){
        return ['id' => "commentQ{$questionNumber}E{$subtask}"];
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

    public static function questionScoreFieldLocator($questionNumber)
    {
        return ['id' => "questionScore{$questionNumber}"];
    }


    /* ----------- Letter grade button -----------*/
    public static $letterGradeButtonContainerXPath = "//*[@id='letterGradeArea']";
    public static $letterGradeButtonText = "Letter grade";
    public static $letterGradeListXPath = "//*[@id='letterGradeList']";

    public static $letterGradeListLocator = ['id' => 'letterGradeList'];


    /**
     * Returns the xpath to the label of the button
     * @param $questionNumber
     * @return string
     */
    public static function letterGradeButtonLabelXPath($questionNumber){
        return "//*[@id='letterGradeForQuestion{$questionNumber}']";
    }

    public static function letterGradeButtonLocator($questionNumber){
        return ['id' => "letterGradeForQuestion{$questionNumber}"];
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
    
    /* --------------- Actions ----------------- */
    public static function navigateToGradingPage($I, $examId){
        $I->test_login($I);
        $I->amOnPage(self::route($examId));
        $I->waitForElementVisible(self::$mainBodyLocator);

        $I->amGoingTo("Check that the page title and url are correct");
        $I->seeInCurrentUrl(self::route($examId));
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageSubHeadingText);
    }


    /**
     * Clicks on the student and waits for the main
     * question panel to become visible.
     * Note that if grading was already underway, this
     * won't be enough to test for the expected effect.
     * @param $I
     * @param $rowId
     * @param int $waitTime
     */
    public static function clickStudentRow($I, $rowId, $waitTime=30){
        $I->amGoingTo("Click on row {$rowId} and check that the questions field displays");
        $I->seeElement(['id' => "studentListItem{$rowId}"]);
        $I->click(['id' => "studentListItem{$rowId}"]);
        $I->waitForElementVisible(self::$questionPanelLocator, $waitTime);
    }

    /**
     * Clicks on the specified question tab and waits for the question area to show.
     * If $checkNotVisibleFirst is true, it checks that the tab is hidden. Then checks
     * that the tab is displayed.
     * @param $I
     * @param $questionNumber
     * @param bool $checkNotVisibleFirst
     */
    public static function clickQuestionTab($I, $questionNumber, $checkNotVisibleFirst = false){
        if($checkNotVisibleFirst)
        {
            $I->expectTo("not see the question panel for question $ {$questionNumber}");
            $I->dontSeeElement(['css' => "#panelQuestion{$questionNumber}"]);
        }
        $I->amGoingTo("click the tab for question #{$questionNumber}");

        $I->click(['xpath' => self::questionPanelTabXPath($questionNumber)]);
        $I->waitForElementVisible(['css' => "#panelQuestion{$questionNumber}"]);
        $I->seeElement(['css' => "#panelQuestion{$questionNumber}"]);
    }
    
    /* ----------------- Assertions ---------- */
public static function verifyGradingPageIntact($I, $examId){
    $I->amGoingTo("Check that all fields and default text are present");
    $I->seeInCurrentUrl(self::route($examId));
    $I->seeInTitle(self::$pageTitleText);
    $I->see(self::$pageSubHeadingText);

    $I->seeElement(['xpath' => self::$studentsTableXPath]);
    $I->seeElement(['xpath' => self::$gradingStatsPanelXPath]);
    //$I->see(self::$finishButtonText);

    //active student fields
    $I->seeElement(self::$activeStudentIdFieldLocator);
    //$I->seeInField(self::$activeStudentIdFieldLocator, self::$activeStudentIdFieldDefaultText);
    $I->seeElement(self::$activeStudentNameFieldLocator);
    //$I->seeInField(self::$activeStudentNameFieldLocator, self::$activeStudentNameFieldDefaultText);
}

    public static function assertGradingPanelVisible($I, $not=false){
        if($not){
            $I->expect("not to see the panel with grading fields");
            $I->dontSeeElement(self::$questionPanelLocator);
        }else{
            $I->expect("to see the panel with grading fields");
            $I->seeElement(self::$questionPanelLocator);
        }
    }

    public static function assertQuestionTabsVisible($I, $numberOfQuestions){
        for ( $i = 1; $i <= $numberOfQuestions; $i++ )
        {
            $I->expectTo("see the question tab for q{$i}");
            $I->see("Q{$i}");
            $I->seeElement(['xpath' => self::questionPanelTabXPath($i)]);
        }
    }


    /**
     * Tests to make sure all expected items are present in the
     * specified panel.
     * @param $I
     * @param $questionNumber
     * @param $numElements
     */
    public static function assertQuestionPanelIntact($I, $questionNumber, $numElements){
        
        $I->expectTo("see that the letter grade button and question score field are present");
        $I->seeElement(['xpath' =>self::letterGradeButtonLabelXPath($questionNumber)]);
        $I->seeElement(['xpath' =>self::letterGradeButtonXPath($questionNumber)]);
        $I->see(self::$letterGradeButtonText);
        $I->seeElement(['xpath' => self::questionScoreFieldXPath($questionNumber)]);

        $I->amGoingTo("Check that the element fields for question {$questionNumber} are displayed properly");
        for ( $j = 1; $j <= $numElements; $j++ )
        {
            $I->expectTo("see the div for element Q{$questionNumber}E{$j}");
            $I->seeElement(['xpath' => self::elementAreaXPath($questionNumber, $j)]);
            $I->expectTo("see the common part of the element name ");
            $I->see("Element #{$j}: ");
            //todo expected element nameself::
            $I->expectTo("see the comment area for Q{$questionNumber}E{$j}");
            $I->seeElement(['xpath' => self::commentXPath($questionNumber, $j)]);
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
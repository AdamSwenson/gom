<?php
namespace Page\grade;

class GradeSelectExamPage
{
    public static $routeRoot = 'http://localhost:8000';

    // include url of current page
    public static $URL = '/grade';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    #common
    public static $mainBodyLocator = ['id' => "gradeSelectExamPage"];
    public static $pageHeadingText = "Grade Exam";
    public static $pageSubHeadingText = "Select an exam1 to grade";
    public static $pageTitleText = 'Grade Exam | gradeomatic';


    public static $gradeButtonClass = "gradeButton";
    public static $assignButtonClass = "assignButton";


    public static $gradeButtonText = "Grade";
    public static $assignButtonText = "Assign";

    //Error modal text classes
    public static $noStudentsErrorClass = "noStudentsError";
    public static $noQuestionsErrorClass = 'noQuestionsError';

    public static function confirmButtonLocator(){
        return ['css' => "body > div.bootbox.modal.fade.in > div > div > div.modal-footer > button"];
    }


    public static function numberStudentsCellLocator($examId){
        return ['css' => "#numStudents{$examId}"];
    }

    public static function numberQuestionsCellLocator($examId){
        return ['css' => "#numQuestions{$examId}"];
    }

    public static function numberGradedCellLocator($examId){
        return ['css' => "#numGraded{$examId}"];
    }
    /**
     * Returns the expected term string for exams found on this page
     * @param $examId
     * @return string
     */
    public static function examTerm($examId)
    {

        $examYear = 1990; //all exams are this year
        return "exam1{$examId}Term {$examYear}";
    }

    /**
     * Returns part of the test data examName
     * @param $examId
     * @return string
     */
    public static function partialExamName($examId)
    {
        return "TestExam#{$examId}";
    }

    public static function gradeButtonId($examId)
    {
        return "gradeExam{$examId}";
    }

    /**
     * @deprecated
     * @param $examId
     * @return string
     */
    public static function gradeButtonXPath($examId)
    {
        return "//*[@id='gradeExam{$examId}']";
    }

    public static function gradeButtonLocator($examId)
    {
        return ["id" => "gradeExam{$examId}"];
    }


    public static function assignButtonId($examId)
    {
        return "assignExam{$examId}";
    }

    /**
     * @deprecated
     * @param $examId
     * @return string
     */
    public static function assignButtonXPath($examId)
    {
        return "//*[@id='assignExam{$examId}']";
    }

    public static function assignButtonLocator($examId)
    {
        return ['id' => "assignExam{$examId}"];
    }

    /**
     * Returns the route that the grade button should direct to
     * @param $examId
     * @return string
     */
    public static function gradeButtonTargetRoute($examId, $withRoot=false)
    {
        $prefix = ($withRoot ? self::$routeRoot : '');
        return $prefix . "/grade/exam1/{$examId}";
    }

    /**
     * @param $examId
     * @return string
     */
    public static function assignButtonTargetRoute($examId, $withRoot=false)
    {
        $prefix = ($withRoot ? self::$routeRoot : '');
        return $prefix . "/grade/exam1/{$examId}/assign";
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }
    /* --------------------------------- helpers ---------------------- */

    public static function navigateToPage($I){
        $I->test_login($I);
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }


    /**
     * The redis based storage does not make it certain that there will
     * always be an expected value for the statistics displayed.
     * This uses javascript to set the relevant value for testing.
     * It also tests that the value is visible.
     * @param $I
     * @param $examId
     * @param $numStudents
     */
    public static function setNumberStudents($I, $examId, $numStudents){
        $I->executeJS("document.getElementById('numStudents{$examId}').innerHTML = $numStudents;" );
        $I->wait(1);
        $I->see($numStudents, ['css' => '#numStudents' . $examId ]);
    }

    /**
     * The redis based storage does not make it certain that there will
     * always be an expected value for the statistics displayed.
     *
     * This uses javascript to set the number of questions value for testing.
     * It also tests that the value is visible.
     * @param $I
     * @param $examId
     * @param $numQuestions
     */
    public static function setNumberQuestions($I, $examId, $numQuestions){
        $I->executeJS("document.getElementById('numQuestions{$examId}').innerHTML = $numQuestions;" );
        $I->wait(1);
        $I->see($numQuestions, ['css' => '#numQuestions' . $examId ]);
    }


   /* ----------------------------------- tests ------------------------ */
    /**
     * Tests whether the specified exam1 row is present
     * @param $I
     * @param $examId
     */
    public static function checkExamRowPresentForGradeExamSelectPage($I, $examId){
        $I->amGoingTo("Check that see exam1 #{$examId}term and title");
        $I->see(self::examTerm($examId));
        $I->see(self::partialExamName($examId));

        $I->amGoingTo("Check to make sure the stats cells are present for exam1 #{$examId}");
        $I->seeElement(self::numberGradedCellLocator($examId));
        $I->seeElement(self::numberStudentsCellLocator($examId));
        $I->seeElement(self::numberQuestionsCellLocator($examId));

        $I->amGoingTo("Check that see correct grade button for exam1 #{$examId}");
        //$I->seeLink(self::$gradeButtonText, self::gradeButtonTargetRoute($examId, true));
        $I->seeElement(self::gradeButtonLocator($examId));

        $I->amGoingTo("Check that see correct assign button for exam1 #{$examId}");
        //$I->seeLink(self::$assignButtonText, self::assignButtonTargetRoute($examId, true));
        $I->seeElement(self::assignButtonLocator($examId));

    }

    /**
     * For the index page displayed on route: '/grade'
     * Runs assertions to make sure see all fixed page elements, exams belonging to user, and no exams
     * not belonging to the user.
     * @param $I
     * @param $examIdsWhichShouldSee
     * @param $examIdsWhichShouldNotSee
     *
     */
    public static function verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee){
        $I->amGoingTo("Make sure the page is intact and see all expected exams");

        foreach ( $examIdsWhichShouldSee as $id )
        {
            self::checkExamRowPresentForGradeExamSelectPage($I, $id);
        }

        if ( ! empty($examIdsWhichShouldNotSee) )
        {
            $I->amGoingTo("Check that other people's exams are absent");
            foreach ( $examIdsWhichShouldNotSee as $id )
            {
                $I->amGoingTo("Check that do not see exam1 #{$id}'s term and title");
                $I->dontSee(self::examTerm($id));
                $I->dontSee(self::partialExamName($id));

                $I->amGoingTo("Check that do not see exam1 #{$id}'s grade button");
                $I->dontSeeLink(self::$gradeButtonText,self::gradeButtonTargetRoute($id, true));
                $I->dontSeeElement(self::gradeButtonLocator($id));

                $I->expect("not to see exam1 #{$id} assign button");
                $I->dontSeeLink(self::$assignButtonText, self::assignButtonTargetRoute($id, true));
                $I->dontSeeElement(self::assignButtonLocator($id));
            }
        }
    }


}

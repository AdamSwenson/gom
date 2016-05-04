<?php
namespace Page;

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

    public static $pageHeadingText = "Grade Exam";
    public static $pageSubHeadingText = "Select an exam to grade";
    public static $pageTitleText = 'Grade Exam | gradeomatic';

    public static $gradeButtonClass = "gradeButton";
    public static $assignButtonClass = "assignButton";


    public static $gradeButtonText = "Grade";
    public static $assignButtonText = "Assign";

    /**
     * Returns the expected term string for exams found on this page
     * @param $examId
     * @return string
     */
    public static function examTerm($examId)
    {

        $examYear = 1990; //all exams are this year
        return "exam{$examId}Term {$examYear}";
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

    public static function gradeButtonXPath($examId)
    {
        return "//*[@id='gradeExam{$examId}']";
    }

    public static function assignButtonId($examId)
    {
        return "assignExam{$examId}";
    }

    public static function assignButtonXPath($examId)
    {
        return "//*[@id='assignExam{$examId}']";
    }

    /**
     * Returns the route that the grade button should direct to
     * @param $examId
     * @return string
     */
    public static function gradeButtonTargetRoute($examId, $withRoot=false)
    {
        $prefix = ($withRoot ? self::$routeRoot : '');
        return $prefix . "/grade/exam/{$examId}";
    }

    /**
     * @param $examId
     * @return string
     */
    public static function assignButtonTargetRoute($examId, $withRoot=false)
    {
        $prefix = ($withRoot ? self::$routeRoot : '');
        return $prefix . "/grade/exam/{$examId}/assign";
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


}

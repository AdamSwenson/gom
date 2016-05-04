<?php
namespace Page;

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

    //also a typeahead
    public static $selectedStudentField = "/html/body/div[1]/div[1]/div[2]/form/div/div[1]/span";

    public static $finishButtonXPath = "//*[@id='finishButton']";

    public static $numberGradedXPath = "";
    public static $numberRemainingXPath = "";


    public static $nameVisibilityButtonXPath = "//*[@id='nameVisibilityControl']";

    public static function pageHeadingText($term, $year, $examName){
       return <<<TAG
        {$term}, {$year} "$examName"
TAG;      
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }


}
TAG

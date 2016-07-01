<?php
namespace Page\grade;

class GradeAssignPage
{

    public static function URL($examId){
        return "/grade/exam/{$examId}/assign";
    }


    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    #common
    public static $mainBodyLocator = ['id' => 'gradeAssignPage'];
    public static $pageHeadingText = "Assign Grades";
    public static $pageSubHeadingText = "Enter the minimum exam grade for each letter assignment. Blank grades will not be used.";

    public static $pageTitleText = 'Assign Grades | gradeomatic';


}

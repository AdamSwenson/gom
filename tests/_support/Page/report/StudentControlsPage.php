<?php
namespace Page\report;

class StudentControlsPage
{
    // include url of current page
    public static $URL = '';

    public static function URL($examId){
        return "report/{$examId}/students";
}
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $pageTitleText = "Student Controls | gradeomatic";
    public static $pageHeadingText = "Student Controls";
    public static $pageSubHeadingText = "Send email notifications or review student feedback";


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

<?php
namespace Page\report;

class QualityControlPage
{
    // include url of current page
    public static $URL = '';

    public static $mainBodyLocator = 'qualityControlPage';

    public static function URL($examId){
        return "report/{$examId}/qualitycontrol";
    }
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $pageTitleText = "Quality control | gradeomatic";
    public static $pageHeadingText = "Quality Control tools";
    public static $pageSubHeadingText = "Catch grading errors before your students do";
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

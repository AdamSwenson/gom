<?php
namespace Page\report;

class FeedbackPage
{
    // include url of current page
    public static $URL = '';

    public static $elementChartDivClass = "";

    public static function overallChartXPath($accessKey){
        return "//*[@id='overall_s{$accessKey}']";
    }


    public static function elementChartXPath($accessKey, $questionNumber){
        "//*[@id='s{$accessKey}_q{$questionNumber}']";
    }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

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

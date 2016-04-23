<?php
namespace Page;

class ElementEditPage
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $addElementButtonXPath = '//*[@id="addElement"]';

    public static $addElementButtonId = '#addElement';


    /** @var int The number of element areas displayed initially */
    public static $defaultNumElements = 1;


    //nav buttons
    public static $forwardNavButton = '#next-question';
    /** @var string Text of forward nav button if not on last question's elements */
    public static $forwardNavText = 'Next Question';
    /** @var string Text of forward nav button if on last question's elements */
    public static $forwardNavText2 = 'Edit Roster';
    public static $backNavButton = '#prev-question';
    public static $forwardNavXPath = '//*[@id="forwardNavButton"]/div';
    /** @var string Text of back nav button if on first question's elements */
    public static $backNavText = 'Edit Questions';
    /** @var string Text of back nav button if not on first question's elements */
    public static $backNavText2 = 'Previous Question';
    public static $backNavXPath = '//*[@id="backNavButton"]/div';

    //other page features
    public static $pageTitleText = 'Edit Elements | gradeomatic';

    /**
     * Returns the string expected when landing on the element edit page
     * @param $examId
     * @param $questionNumber
     * @return string
     */
    public static function pageHeadingText($examId, $questionNumber){
        return 'Question #' . $questionNumber . ' "Exam' . $examId . 'Question' . $questionNumber .'"';
    }

    /**
     * XPath to the main element item containers
     * @param $subtask
     * @return string
     */
    public static function elementItemXPath($subtask){
        return "//*[@id='elementItem{$subtask}']";
    }

    public static function elementNameXPath($subtask)
    {
        return "//*[@id='elementName{$subtask}']";
    }

    public static function elementTextXPath($subtask)
    {
        return "//*[@id='elementText{$subtask}']";
    }

    public static function customizeResponsesButtonXPath($subtask)
    {
        return "//*[@id='btnCustomizeResponse{$subtask}']";
    }

    public static function commentFormXPath($subtask)
    {
        return "//*[@id='commentForm{$subtask}']";
    }

    public static function valenceTabButton($valence){
        return "//*[@id='tab{$valence}']";
    }

public static function valenceTextPath($subtask, $valence){
    return "//*[@id='e{$subtask}area{$valence}']/textarea";
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

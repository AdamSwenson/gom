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
    #common
    public static $mainBodyLocator = ['id' => 'elementEditPage'];

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


    public static function expectedRedirectRoute($examId, $questionId)
    {
        return "/exam1/{$examId}/question/{$questionId}/element/edit";

}


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     * @param $examId
     * @param $questionId
     * @return string
     */
    public static function route($examId, $questionId)
    {
        return "/exam1/{$examId}/question/{$questionId}/element/edit";

    }

    /* ------------------------- tests ----------------------------- */


    /**
     * Checks whether the fields for creating or editing a given element are present.
     * If not is true, this checks whether there are no fields for the subtask
     * @param $I
     * @param int $subtask
     * @param bool $not
     */
    public static function checkElementFieldsPresent($I, $subtask, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(self::elementItemXPath($subtask));
            $I->dontSeeElement(self::elementNameXPath($subtask));
            $I->dontSeeElement(self::elementTextXPath($subtask));
            $I->dontSeeElement(self::customizeResponsesButtonXPath($subtask));
            $I->dontSeeElement(self::commentFormXPath($subtask));
        } else
        {
            $I->seeElement(self::elementItemXPath($subtask));
            $I->seeElement(self::elementNameXPath($subtask));
            $I->seeElement(self::elementTextXPath($subtask));
            $I->seeElement(self::customizeResponsesButtonXPath($subtask));
            // $I->seeElement(ElementEditPage::commentFormXPath($subtask));
        }
    }

    /**
     * Runs tests for page title, page heading, appropriate navs, and element fields
     * @param $I
     * @param $examId
     * @param $questionId
     * @param $numberOfElements
     */
    public static function verifyElementEditPageIntact($I, $examId, $questionId, $numberOfElements)
    {
        $I->amGoingTo("Check that everything on the element editing page is displayed properly");
        //page level text
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::pageHeadingText($examId, $questionId));
        //page level buttons
        $I->seeElement(self::$addElementButtonXPath);
        //correct navs
        $I->seeElement(self::$forwardNavButton);
        $I->seeElement(self::$backNavButton);
        //fields present
        for ( $i = 1; $i <= $numberOfElements; $i++ )
        {
            self::checkElementFieldsPresent($I, $i);
        }

    }


}

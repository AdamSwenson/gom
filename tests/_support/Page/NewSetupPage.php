<?php

namespace Page;

class newSetupPage
{
    // include url of current page
    public static $URL = '/items';

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
    public static function route( $examId )
    {
        return static::$URL . '/' . $examId;
    }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    #common
    public static $mainBodyLocator = ['id' => 'examEditor'];


    /** @var int The number of element areas displayed initially */
    public static $defaultNumItems = 1;


    //nav buttons
    //other page features
//    public static $pageTitleText = 'Edit Elements | gradeomatic';

    /**
     * Returns the string expected when landing on the element edit page
     * @param $examId
     * @param $questionNumber
     * @return string
     */
    public static function pageHeadingText( $examId, $questionNumber )
    {
//        return 'Question #' . $questionNumber . ' "Exam' . $examId . 'Question' . $questionNumber .'"';
    }

    public static function newItemButtonLocator()
    {
        return ['id' => 'add-item-button'];
    }

    /* ------------------------------------ utilities ------------------ */
    public static function navigateToPage( $I, $examId )
    {
        $I->test_login($I);
        if ( isset($examId) ) {
            $I->amOnPage(self::route($examId));
        } else {
            $I->amOnPage(self::route());
        }
        $I->waitForElement(self::$mainBodyLocator);
    }


    public
    static function examName()
    {
        return ['id' => 'privateName'];
    }

    public
    static function settingsButton()
    {
        return ['class' => 'settings-button'];
    }

    public
    static function addSiblingButton()
    {
        return ['class' => 'addSibling'];
    }

    public
    static function valenceTabButton( $valence )
    {
        return "//*[@id='tab{$valence}']";
    }

    public
    static function valenceTextPath( $subtask, $valence )
    {
        return "//*[@id='e{$subtask}area{$valence}']/textarea";
    }


    /* ------------------------- tests ----------------------------- */


    /**
     * Checks whether the fields for creating or editing a given element are present.
     * If not is true, this checks whether there are no fields for the subtask
     * @param $I
     * @param int $subtask
     * @param bool $not
     */
    public
    static function checkElementFieldsPresent( $I, $subtask, $not = false )
    {
//        if ( $not )
//        {
//            $I->dontSeeElement(self::elementItemXPath($subtask));
//            $I->dontSeeElement(self::elementNameXPath($subtask));
//            $I->dontSeeElement(self::elementTextXPath($subtask));
//            $I->dontSeeElement(self::customizeResponsesButtonXPath($subtask));
//            $I->dontSeeElement(self::commentFormXPath($subtask));
//        } else
//        {
//            $I->seeElement(self::elementItemXPath($subtask));
//            $I->seeElement(self::elementNameXPath($subtask));
//            $I->seeElement(self::elementTextXPath($subtask));
//            $I->seeElement(self::customizeResponsesButtonXPath($subtask));
//            // $I->seeElement(ElementEditPage::commentFormXPath($subtask));
//        }
    }

    /**
     * Runs tests for page title, page heading, appropriate navs, and element fields
     * @param $I
     * @param $numberOfItems
     */
    public
    static function verifyPageIntact( $I, $numberOfItems )
    {
        $I->amGoingTo("Check that everything on the item page w/r/t element editing page is displayed properly");
        //page level text
        $I->seeElement(self::$mainBodyLocator);

        $I->seeElement(['class' => 'exam1-card-component']);

        $I->amGoingTo('check that the expected number of item cards are displayed');
        if ( isset($numberOfItems) && $numberOfItems > 0 ) {
            for ( $i = 1; $i < $numberOfItems; $i++ ) {
                $I->seeElement(self::itemCardLocator($i));
            }
        }

//        $I->seeInTitle(self::$pageTitleText);
//        $I->see(self::pageHeadingText($examId, $questionId));
//        //page level buttons
//        $I->seeElement(self::$addElementButtonXPath);
//        //correct navs
//        $I->seeElement(self::$forwardNavButton);
//        $I->seeElement(self::$backNavButton);
//        //fields present
//        for ( $i = 1; $i <= $numberOfElements; $i++ )
//        {
//            self::checkElementFieldsPresent($I, $i);
//        }

    }


}

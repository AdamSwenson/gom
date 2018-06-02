<?php
namespace Page\setup;

class ExamEditPage
{
    // include url of current page
    public static $URL = '/exam';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    #common
    public static $mainBodyLocator = ['id' => 'editExamPage'];
    public static $pageHeadingText = 'Create Exam';
    public static $pageTitleText = 'Create Exam | gradeomatic';


    #form fields
    public static $examNameField = 'name';
    public static $examNameFieldLocator = ['id' => 'name'];
    public static $termSelectId = 'term';
    public static $termSelectLocator = ['id' => 'term'];
    public static $yearSelectId = '';
    public static $yearSelectLocator = ['id' => 'year'];

    public static $forwardNavButton = "#forwardNavButton";

    public static $defaultTerms = ['Winter', 'Spring','Summer','Fall'];
    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /* ------------------------------- tools ------------------- */
    public static function navigateToPage($I)
    {
        $I->test_login($I);
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }

    /* -------------------------- tests -------------------------- */
    public static function assertPageIntact($I)
    {
        $I->expectTo("See all the major page level elements and form fields");
        $I->seeInTitle(self::$pageTitleText);
        $I->seeInCurrentUrl(self::$URL);
        $I->see(self::$pageHeadingText);
        $I->seeElement(self::$mainBodyLocator);


    }
}

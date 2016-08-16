<?php
namespace Page\report;

class AnalyticsPage
{

    public static function URL($examId){
        return "/report/{$examId}/analytics";
    }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $pageTitleText = "Analytics | gradeomatic";

    public static $questionScoreAreaHeading = "Question Score Statistics";
    public static $elementScoreAreaHeading = "Element Score Statistics";

    public static function pageHeadingText($examName, $term, $year){
        return "Analytics: $term $year " . '"' . $examName . '"';
    }


    public static $mainBodyLocator = ['id' => 'app'];

    public static $questionStatsTableLocator = ['id' => 'questionStatsTableArea'];
    public static $questionScoreBoxplotLocator = ['id' => 'questionScoreBoxplot'];
    public static $elementStatsTableLocator = ['id' => 'elementStatsTableArea'];

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /* ------------------------------- Tools ------------------------------------------ */

    public static function navigateToPage($I, $examId)
    {
        $I->amGoingTo("Navigate to the analytics page for exam " . $examId);
        $I->test_login($I);
        $I->amOnPage(self::URL($examId));
        $I->waitForElementVisible(self::$mainBodyLocator);
    }


    /* ------------------------------- Assertions ------------------------------------- */
    public static function assertPageIntact($I, $examId, $examName, $term, $year)
    {
        $I->amGoingTo("Check that the main page components are displayed as expected");
        $I->seeInTitle(self::$pageTitleText);
        $I->seeInCurrentUrl(self::URL($examId));

        $I->expectTo("see major headings in the page");
        $I->see(self::pageHeadingText($examName, $term, $year));
        $I->see(self::$questionScoreAreaHeading);
        $I->see(self::$elementScoreAreaHeading);

        $I->expectTo("see main data display areas");
        $I->seeElement(self::$questionStatsTableLocator);
        //$I->seeElement(self::$questionScoreBoxplotLocator);
        $I->seeElement(self::$elementStatsTableLocator);
    }

}

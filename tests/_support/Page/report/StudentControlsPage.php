<?php
namespace Page\report;

class StudentControlsPage
{

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function URL($examId)
    {
        return "report/{$examId}/students";
    }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $mainBodyLocator = ['id' => 'studentControlsPage'];
    public static $pageTitleText = "Student Controls | gradeomatic";
    public static $pageHeadingText = "Student Controls";
    public static $pageSubHeadingText = "Send email notifications or review student feedback";


    public static $noStudentsMessageText = "This exam1 has no students associated with it.";
    public static $noStudentsMessageClassName = "noStudentsMessage";

    public static $controlRowClassName = "studentControlRow";


    public static function navigateToPage($I, $examId){
        $I->test_login($I);
        $I->amOnPage(self::URL($examId));
        $I->waitForElementVisible(self::$mainBodyLocator);
    }
}

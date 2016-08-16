<?php
namespace Page\report;

class FeedbackLoginPage
{
    // include url of current page
    public static $URL = 'feedback/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $mainBodyLocator = ['id' => 'feedbackLoginPage'];

    public static $pageTitleText = "Your feedback";

    public static $accessKeyFieldLocator = ['id' => "accessKey"];
    public static $accessKeyFieldId = "accessKey";

    public static $submitButtonLocator = ['id' => 'submit'];
    public static $submitButtonId = "submit";
    public static $submitButtonText = "View Feedback";

    public static $blankKeyErrorMessage = "Please enter your access key";

    public static function verifyPageIntact($I){
        $I->amGoingTo("Check that the login page displays properly");
        $I->seeInCurrentUrl(self::$URL);
        $I->seeInTitle(self::$pageTitleText);
        $I->seeElement(['id' => self::$accessKeyFieldId], ['name' => self::$accessKeyFieldId]);
        $I->seeElement(['id' => self::$submitButtonId], ['name' => self::$submitButtonId]);
        $I->see(self::$submitButtonText);
    }

    /**
     * Creates the url to view feedback that a student would receive in their email
     * @param $accessKey
     * @return string
     */
    public static function routeWithAccessKeyInRequest($accessKey){
        return static::$URL . '?accessKey=' . $accessKey;
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

    public static function navigateToPage($I)
    {
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }

}

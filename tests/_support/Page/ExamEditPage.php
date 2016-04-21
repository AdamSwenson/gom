<?php
namespace Page;

class ExamEditPage
{
    // include url of current page
    public static $URL = '/exam/create';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
public static $examNameField = 'name';
    public static $termSelectId = 'term';
    public static $yearSelectId = '';

    public static $pageHeadingText = 'Create Exam';
    public static $pageTitleText = 'Create Exam | gradeomatic';

    public static $forwardNavButton = "#forwardNavButton";

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

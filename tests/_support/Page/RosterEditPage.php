<?php
namespace Page;

class RosterEditPage
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $importRosterButton = '#fileInput';
    public static $addStudentButton = '';
    public static $deleteRosterButton = '';
    public static $forwardNavButton = '#forwardNavButton';
    public static $backNavButton = '#backNavButton';
    
    public static $pageTitleText = 'Edit Roster | gradeomatic';

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

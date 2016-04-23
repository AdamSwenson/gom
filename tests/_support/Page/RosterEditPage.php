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
    public static $addStudentButton = '#addStudent';
    public static $deleteRosterButton = '#deleteRoster';
    public static $postDeleteMessageCloseButton = '/html/body/div[3]/div/div/div[2]/button';
    //.postDeleteMessageCloseButton';


    //warning modals
    public static $rosterDeleteModalCancelButton = '.cancelRosterDelete';
    public static $rosterDeleteModalConfirmButton = '.confirmRosterDelete';

    public static $deleteStudentWarningModalText = "Warning: this will delete the student, including their feedback and scores.";
    public static $deleteRosterWarningModalText = "Warning: This will remove all students from the current roster, including their grades and feedback.";
    public static $postDeleteMessage = "Removal of students will not be complete until you click 'Save and Finish'.";

    //nav buttons
    public static $forwardNavButton = '#forwardNavButton';
    public static $forwardNavText = 'Save & Finish';
    public static $backNavButton = '#backNavButton';
    public static $forwardNavXPath = '//*[@id="forwardNavButton"]/div';
    public static $backNavText = 'Edit Elements';
    public static $backNavXPath = '//*[@id="backNavButton"]/div';

    //other page features
    public static $pageTitleText = 'Edit Roster | gradeomatic';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }


    public static function makeIdString($i)
    {
        $idsSet = [3, 4, 5];
        if ( in_array($i, $idsSet) )
        {
            return "{$i}{$i}{$i}{$i}{$i}{$i}{$i}{$i}{$i}";
        }

        return null;
    }

    public static function makeEmail($i)
    {
        $emailSet = [2, 4, 5];
        if ( in_array($i, $emailSet) )
        {
            return "student{$i}@email.com";
        }

        return null;
    }

    public static function students1Through5()
    {
        $out = [];
        for ( $i = 1; $i <= 5; $i++ )
        {
            $out[ $i ] = [
                'last'  => "lastNameOfExisting{$i}",
                'first' => "firstNameOfExisting{$i}",
                'sid'   => self::makeIdString($i),
                'email' => self::makeEmail($i),
            ];
        }

        return $out;
    }


}

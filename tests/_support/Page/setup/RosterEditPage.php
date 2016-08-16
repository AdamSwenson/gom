<?php
namespace Page\setup;

class RosterEditPage
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    #common
    public static $mainBodyLocator = ['id' => 'rosterEditPage'];
    public static $pageTitleText = 'Edit Roster | gradeomatic';


    # buttons
    public static $importRosterButton = '#fileInput';

    /** @var string
     * @deprecated */
    public static $addStudentButton = '#addStudent';
    public static $addStudentButtonLocator = ['id' => 'addStudent'];

    /** @var string
     * @deprecated
     */
    public static $deleteRosterButton = '#deleteRoster';
    public static $deleteRosterButtonLocator = ['id' => 'deleteRoster'];


    //warning modals
    # Student delete
    public static $deleteConfirmationModalLocator = ['class' => 'confirmationModal'];
    public static $deleteConfirmButtonLocator = ['css' => "button.btn.btn-danger.btn-sm.deleteConfirmButton"];
    public static $deleteCancelButtonLocator = ['css' => "button.btn.btn-sm.cancelButton"];
    public static $deleteStudentWarningModalText = "Warning: this will delete the student, including their feedback and scores.";

    # Import roster
    public static $importHelpModalLocator = ['class' => 'importHelpModal'];


    # Roster delete
    /** @var string
     * @deprecated
     */
    public static $rosterDeleteModalCancelButton = '.cancelRosterDelete';
    public static $rosterDeleteCancelButtonLocator = ['css' => 'button.btn.btn-sm.cancelRosterDelete'];

    /** @var string
     * @deprecated
     */
    public static $rosterDeleteModalConfirmButton = '.confirmRosterDelete';
    public static $rosterDeleteConfirmButtonLocator = ['css' => 'button.btn.btn-danger.btn-sm.confirmRosterDelete'];
    public static $deleteRosterWarningModalText = "Warning: This will remove all students from the current roster, including their grades and feedback.";

    public static $postDeleteModalLocator = ['class' => 'postDeleteMessage'];
    public static $postDeleteMessage = "Removal of students will not be complete until you click 'Save and Finish'.";

    public static $postDeleteMessageCloseButtonLocator = ['css' => 'div.modal-footer > button']; 
//        ['xpath' => '/html/body/div[3]/div/div/div[2]/button'];


    #nav buttons
    /** @var string
     * @deprecated
     */
    public static $forwardNavButton = '#forwardNavButton';
    public static $forwardNavText = 'Save & Finish';
    public static $forwardNavLocator = ['xpath' => '//*[@id="forwardNavButton"]/div'];
    /** @var string
     * @deprecated
     */
    public static $forwardNavXPath = '//*[@id="forwardNavButton"]/div';
    /** @var string
     * @deprecated
     */
    public static $backNavButton = '#backNavButton';
    public static $backNavLocator = ['xpath' => '//*[@id="backNavButton"]/div'];
    public static $backNavText = 'Edit Elements';
    /** @var string
     * @deprecated
     */
    public static $backNavXPath = '//*[@id="backNavButton"]/div';

    //other page features

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

    /* --------------------------------- tools ----------------------- */
    public static function navigateToPage($I, $examId)
    {
        $I->test_login($I);
        # Go to page
        $I->amOnPage("/exam/{$examId}/student/edit");
        $I->waitForElementVisible(self::$mainBodyLocator);
    }

    /* ---------------------------------- tests --------------------- */

    public static function verifyRosterEditPageIntact($I)
    {
        $I->amGoingTo("Check that the page is in its initial state and everything is displayed as expected");
        $I->seeInTitle(self::$pageTitleText);

        //correct navs
        $I->seeElement(self::$forwardNavButton);
        $I->see(self::$forwardNavText, RosterEditPage::$forwardNavXPath);
        $I->seeElement(self::$backNavButton);
        $I->see(self::$backNavText, RosterEditPage::$backNavXPath);
    }

    public static function verifyInitialValuesPresent($I)
    {
        //expected students
        $students = RosterEditPage::students1Through5();
        for ( $i = 1; $i <= count($students); $i++ )
        {
            $v = $students[ $i ];
            $I->seeInField("form input[type=text]", $v['last']);
            $I->seeInField("form input[type=text]", $v['first']);
            if ( ! is_null($v['sid']) )
            {
                $I->seeInField("form input[type=text]", $v['sid']);
            }
            if ( ! is_null($v['email']) )
            {
                $I->seeInField("form input[type=text]", $v['email']);
            }
        }
    }

}

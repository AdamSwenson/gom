<?php
namespace Page\report;

class ReportIndexPage
{
    // include url of current page
    public static $URL = '/report';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $mainBodyLocator = ['id' => 'examControlsPage'];
    public static $pageTitleText = "Reports | gradeomatic";
    public static $pageHeadingText = "Post-Grading Tasks";
    public static $pageSubHeadingText = "Release grades to students or view data about an exam1";

    public static $releaseToggleOnText = "Hide exam1 from students";
    public static $releaseToggleOffText = "Release exam1 to students";


    /* ------------ Analytics ---------- */
    public static $analyticsText = "Analytics";

    /**
     * <a href="http://localhost:8000/report/3/analytics">
     * @param $examId
     * @return string
     */
    public static function analyticsLink($examId)
    {
        return "/report/{$examId}/analytics";
    }

    /**
     * Path to the student controls link for clicking etc
     * @param $examId
     * @return array
     */
    public static function analyticsLinkLocator($examId)
    {
        return ['css' => "#reportsForExam{$examId} .analyticsLink"];
    }


    /* ------------ Quality control ---------- */
    public static $qualityControlText = "Quality Control Tools";

    /**
     * <a href="http://localhost:8000/report/3/qualitycontrol">
     * @param $examId
     * @return string
     */
    public static function qualityControlLink($examId)
    {
        return static::$URL . "/{$examId}/qualitycontrol";
    }

    /**
     * Path to the quality control link for clicking etc
     * @param $examId
     * @return array
     */
    public static function qualityControlLinkLocator($examId)
    {
        return ['css' => "#reportsForExam{$examId} .qualityControlLink"];
    }


    /* ------------ Export ---------- */
    public static $exportControlsText = "Export Scores to Spreadsheet";

    /**
     * <a href="http://localhost:8000/backup/3">
     * @param $examId
     * @return string
     */
    public static function exportControlsLink($examId)
    {
        return "/backup/{$examId}";
    }

    /**
     * Path to the export scores link for clicking etc
     * @param $examId
     */
    public static function exportControlsLinkLocator($examId)
    {
        ['css' => "#reportsForExam{$examId} .backupLink"];
    }


    /* ------------ Student controls ---------- */
    public static $studentControlsText = "Student Controls";

    /**
     * @param $examId
     * @return string
     */
    public static function studentControlsLink($examId)
    {
        return static::$URL . "/{$examId}/students";
    }

    /**
     * Path to the student controls link for clicking etc
     * @param $examId
     * @return array
     */
    public static function studentControlsLinkLocator($examId)
    {
        return ['css' => "#reportsForExam{$examId} .studentControlsLink"];
    }


    /* ------------ Page level controls ---------- */
    public static function examRowLocator($examId)
    {
        return ['id' => "reportsForExam{$examId}"];
    }

    public static function dropdownButtonLocator($examId)
    {
        return ['css' => "#reportsForExam{$examId} .dropdown-toggle"];
    }

    public static function releaseToggleLocator($examId)
    {
        return ['css' => "#reportsForExam{$examId} .toggle"];
    }


    /* ------------ Release and hide ---------- */
//    public static function confirmButtonLocator()
//    {
//        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-primary'];
//    }
//
//    public static function cancelButtonLocator()
//    {
//        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-default'];
//    }

    /** @var array Shared by all confirmation modals */
    public static $confirmationModalLocator = ['class' => 'confirmationModal'];

    public static $releaseConfirmButtonLocator = ['css' => 'button.btn.btn-sm.btn-danger.confirmRelease'];
    public static $releaseCancelButtonLocator = ['css' => 'button.btn.btn-sm.cancelRelease'];
    public static $hideConfirmButtonLocator = ['css' => 'button.btn.btn-sm.btn-danger.confirmHide'];


//Classes for the message text
    public static $modalTextClass = "confirmText";
    public static $releaseTextClass = "releaseConfirmText";
    public static $reReleaseTextClass = "reReleaseConfirmText";
    public static $hideTextClass = "hideConfirmText";

    public static $successTextClass = "successText";
    public static $releaseSuccessTextClass = "releaseSuccess";
    public static $hideSuccessTextClass = "hideSuccess";

    public static $errorTextClass = "errorText";
    public static $releaseErrorTextClass = "releaseError";
    public static $hideErrorTextClass = "hideError";

    public static $releaseConfirmationText = "Releasing this exam1 will e-mail all students their grades and personalized feedback. Do you wish to continue?";

    public static $reReleaseConfirmationText = "";

    public static $hideConfirmationText = "Removing access will prevent students from viewing feedback on the exam1. Access can be restored by releasing the exam1 again.";
    public static $releaseSuccessText = "All students have been e-mailed!";
    public static $hideSuccessText = "All student access to the exam1 has been removed!";

    public static $releaseErrorText = "Sorry, there was a problem releasing this exam1! Please try again.";
    public static $hideErrorText = "Sorry, there was a problem hiding this exam1! Please try again.";


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /* ----------------------------------- Tools -------------------------- */
    public static function navigateToReportIndexPage($I){
        $I->test_login($I);
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);
    }


    /* ----------------------------------- Tests -------------------------- */
    /**
     * @param $I
     * @param $numberOfExams
     * @param $examIdsToSkip
     */
    public static function verifyPageIntact($I, $numberOfExams, $examIdsToSkip)
    {

        $I->amGoingTo("Check that the page title and url are correct");
        $I->seeInCurrentUrl(self::$URL);
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageSubHeadingText);

        $I->expectTo("see the standard page text components");
        $I->seeInTitle(self::$pageTitleText);
        $I->see(self::$pageHeadingText);
        $I->see(self::$pageSubHeadingText);

        $I->expectTo("see a table row with buttons for each exam1");
        if ( $numberOfExams > 0 )
        {
            for ( $i = 1; $i <= $numberOfExams; $i++ )
            {
                if ( ! in_array($i, $examIdsToSkip) )
                {
                    $I->seeElement(self::examRowLocator($i));
                    $I->seeElement(self::dropdownButtonLocator($i));
                    $I->seeElement(self::releaseToggleLocator($i));
                }
            }
        } else
        {
            //if visited before created an exam1
            $I->seeElement(self::examRowLocator(0));
        }
    }


    /**
     * Tests whether the exam1's toggle is showing it as released/not released
     * @param $I
     * @param $examId
     * @param bool $isReleased
     */
    public static function checkExamReleased($I, $examId, $isReleased = false)
    {
        $n = $isReleased ? '' : 'not';
        $text = $isReleased ? self::$releaseToggleOnText : self::$releaseToggleOffText;

        $I->expectTo("see that exam1 #{$examId} is $n released");
        $I->seeElement(self::releaseToggleLocator($examId));
        $I->see($text, self::releaseToggleLocator($examId));
    }


}

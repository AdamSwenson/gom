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
    public static $pageTitleText = "Reports | gradeomatic";
    public static $pageHeadingText = "Post-Grading Tasks";
    public static $pageSubHeadingText = "Release grades to students or view data about an exam";

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


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /* ----------------------------------- Tests -------------------------- */
    /**
     * @param $I
     * @param $numberOfExams
     * @param $examIdsToSkip
     */
    public static function verifyPageIntact($I, $numberOfExams, $examIdsToSkip)
    {
        $I->expectTo("see the standard page text components");
        $I->seeInTitle(ReportIndexPage::$pageTitleText);
        $I->see(ReportIndexPage::$pageHeadingText);
        $I->see(ReportIndexPage::$pageSubHeadingText);

        $I->expectTo("see a table row with buttons for each exam");
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
            //if visited before created an exam
            $I->seeElement(self::examRowLocator(0));
        }
    }

}

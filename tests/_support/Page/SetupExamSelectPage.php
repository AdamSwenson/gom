<?php
namespace Page;

class SetupExamSelectPage
{
    // include url of current page
    public static $URL = '/exam';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $pageTitleText = 'Setup exam';

    public static $pageHeadingText = 'Exam Setup';
    public static $pageHeadingSubText = 'Create, edit and delete exams';

    public static $cloneButtonClass = 'cloneExam';
    public static $editButtonClass = 'editExam';
    public static $deleteButtonClass = 'deleteExam';

    public static $cloneButtonTitle = 'Clone Exam';
    public static $editButtonTitle = 'Edit Exam';
    public static $deleteButtonTitle = 'Delete Exam';

    public static $cloneButtonText = 'Clone';
    public static $editButtonText = 'Edit';
    public static $deleteButtonText = 'Delete';

    public static $forwardNavButtonText = "Create New Exam";
    public static $forwardNavButton = "#forwardNavButton";

    public static $deleteExamCancelButtonXPath = "/html/body/div[5]/div/div/div[3]/button[1]";
public static $deleteExamConfirmButtonXPath = "/html/body/div[5]/div/div/div[3]/button[2]";
    public static $deleteExamConfirmationText ="Warning: This will delete all associated students, scores, questions and elements. Do you wish to proceed?";


    public static function forwardNavButtonTarget(){
        $routeBase = "http://localhost:8000";
        return $routeBase . "/exam/create";
    }

    /**
     * Returns the text that will be displayed in the term column
     * @param $examId
     * @return string
     */
    public static function examTerm($examId){
        $examYear = 1990; //all exams are this year
        return "exam{$examId}Term {$examYear}";
    }

    /**
     * Returns the part of the exam name which is constant to all test exams
     * @param $examId
     * @return string
     */
    public static function partialExamName($examId){
        return "TestExam#{$examId}";
    }

    public static function cloneButtonTargetRoute($examId)
    {
        return "/exam/{$examId}/clone";
    }

    public static function editButtonTargetRoute($examId)
    {
        return "/exam/{$examId}/edit";
    }

    public static function examRowId($examId){
        return "examRow{$examId}";
    }

    public static function cloneButtonXPath($examId){
        return "//*[@id='examRow{$examId}']/td[5]/a[2]";
    }

    public static function deleteButtonXPath($examId){
        return "//*[@id='examRow{$examId}']/td[5]/a[3]";
    }

    public static function editButtonXPath($examId){
        return "//*[@id='examRow{$examId}']/td[5]/a[1]";
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


}

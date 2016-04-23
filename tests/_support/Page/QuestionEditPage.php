<?php
namespace Page;

class QuestionEditPage
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /** @var int The number of question fields displayed for a new exam */
    public static $defaultNumberOfQuestions = 1;

    //Fields
    public static $questionNameIdBase = '#questionName';
    public static $questionTextIdBase = '#questionText';
    public static $maxScoreIdBase = '#maxScore';
    /** @var string The class shared by all move buttons */
    public static $moveButtonClass = "handle";
    /** @var string The class all the delete buttons share */
    public static $deleteButtonClass = "js-remove";
    public static $addQuestionButtonId = "#addQuestion";

    //Visible page text
    public static $pageHeadingText = 'Add / Edit Questions: ';
    public static $pageTitleText = 'Edit Questions | gradeomatic';

    //Navigation
    /** @var string Id of the forward navigation button */
    public static $forwardNavButton = "#forwardNavButton";
    /** @var string Text displayed on the button to the user */
    public static $forwardNavButtonText = "";
    /** @var string Id of the back navigation button */
    public static $backNavButton = "#backNavButton";
    /** @var string Text displayed on the back button to the user */
    public static $backNavButtonText = "";

    public static $deleteConfirmationModalText = "Warning: This will permanently delete all elements and scores associated with the question";
//    public static $deleteConfirmationModalText = "<span class='glyphicon glyphicon-warning-sign'></span> Warning: This will permanently delete all elements and scores associated with the question";
    public static $deleteConfirmationModalConfirmButton = '.confirmQuestionDelete';
    public static $deleteConfirmationModalCancelButton = '.cancelQuestionDelete';
//    public static $deleteConfirmationModalConfirmButton = '/html/body/div[5]/div/div/div[3]/button[2]';
//    public static $deleteConfirmationModalCancelButton = '/html/body/div[5]/div/div/div[3]/button[1]';

    /**
     * Returns the xpath of a questionName field
     * The question number will be the last part of the string.
     *
     * @param $questionNumber
     * @return string
     */
    public static function questionNameXPath($questionNumber)
    {
        return "//*[@id='questionName{$questionNumber}']";
    }

    /**
     * Returns the xpath of a questionText field.
     * The question number will be the last part of the string.
     *
     * @param $questionNumber
     * @return string
     */
    public static function questionTextXPath($questionNumber)
    {
        return "//*[@id='questionText{$questionNumber}']";
        //self::$questionTextIdBase + $questionNumber;
    }

    /**
     * Returns the xpath of a maxScoreField.
     * The question number will be the last part of the string.
     *
     * @param $questionNumber
     * @return string
     */
    public static function maxScoreXPath($questionNumber)
    {
        return "//*[@id='maxScore{$questionNumber}']";
    }

    /**
     * Returns the xpath to the button for deleting the question
     * @param $questionNumber
     * @return string
     */
    public static function deleteButtonXPath($questionNumber)
    {
        return "//*[@id='deleteQuestionButton{$questionNumber}']";
//        return "//*[@id='questionItem{$questionNumber}']/div[4]/a";
    }

    /**
     * Returns the xpath to the button for dragging and rearranging questions
     * @param $questionNumber
     * @return string
     */
    public static function moveButtonXPath($questionNumber){
        return "//*[@id='moveQuestionButton{$questionNumber}']";
//        return "//*[@id='questionItem{$questionNumber}']/div[4]/span";
    }

    /**
     * On submit should go to editing elements for question 1. This returns the string to look for in the url.
     * @param $examId
     * @param $questionId
     * @return string
     */
    public static function redirectToUrl($examId, $questionId){
        return "/exam/{$examId}/question/{$questionId}/element/edit";
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

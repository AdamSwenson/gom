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

    /* ------------------------------------------ tests ----------------------------- */

    /**
     * Returns array with keys questionName, questionText, maxScore
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public static function getQuestionFieldsInitialValues($examId, $questionNumber)
    {
        return [
            'questionName' => "Exam{$examId}Question{$questionNumber}",
            'questionText' => "Exam{$examId}Question{$questionNumber} Text.",
            'maxScore'     => 100,
        ];
    }

    /**
     * Checks whether the fields for creating or editing a given question number are present.
     * If not is true, this checks whether there are no fields for the questionNumber
     * @param $I
     * @param $questionNumber
     * @param bool $not
     */
    public function checkQuestionFieldsPresent($I, $questionNumber, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(self::questionNameXPath($questionNumber));
            $I->dontSeeElement(self::questionTextXPath($questionNumber));
            $I->dontSeeElement(self::maxScoreXPath($questionNumber));
        } else
        {
            $I->seeElement(self::questionNameXPath($questionNumber));
            $I->seeElement(self::questionTextXPath($questionNumber));
            $I->seeElement(self::maxScoreXPath($questionNumber));
            //buttons
            $I->seeElement(self::deleteButtonXPath($questionNumber));
            $I->seeElement(self::moveButtonXPath($questionNumber));
        }
    }


    /**
     * Runs tests for page title, page heading, appropriate navs, and question fields
     * @param $I
     * @param $examId
     * @param $examName
     * @param $numberQuestions
     */
    public static function verifyQuestionEditPageIntact($I, $examId, $examName, $numberQuestions)
    {
        $I->amGoingTo("Check that everything is displayed properly");
        $I->seeInCurrentUrl("exam/{$examId}/question/edit");
        $I->seeInTitle(self::$pageTitleText);
        $I->see($examName);
        $I->seeElement(self::$addQuestionButtonId);
        //correct navs
        $I->seeElement(self::$forwardNavButton);
        $I->seeElement(self::$backNavButton);
        //fields present
        for ( $i = 1; $i <= $numberQuestions; $i++ )
        {
            self::checkQuestionFieldsPresent($I, $i);
        }
    }

    public static function verifyQuestionsHaveInitialExpectedValues($I, $examId, $numberQuestions)
    {
        $I->amGoingTo("Check that the questions have the expected text");
        for ( $i = 1; $i <= $numberQuestions; $i++ )
        {
            $v = self::getQuestionFieldsInitialValues($examId, $i);
            //question name
            $I->seeElement(self::questionNameXPath($i));
            $I->seeInField(self::questionNameXPath($i), $v['questionName']);
            //question text
            $I->seeElement(self::questionTextXPath($i));
            $I->seeInField(self::questionTextXPath($i), $v['questionText']);
            //max score
            $I->seeElement(self::maxScoreXPath($i));
            $I->seeInField(self::maxScoreXPath($i), $v['maxScore']);
        }
    }


}

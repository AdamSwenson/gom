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
    #common
    public static $mainBodyLocator = ['id' => 'questionEditPage'];
    public static $pageHeadingText = 'Add / Edit Questions: ';
    public static $pageTitleText = 'Edit Questions | gradeomatic';


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
    /** @var string @deprecated */
    public static $addQuestionButtonId = "#addQuestion";
    public static $addQuestionButtonLocator = ['id' => 'addQuestion'];

    //Navigation
    /** @var string Id of the forward navigation button @deprecated */
    public static $forwardNavButton = "#forwardNavButton";
    /** @var string Id of the forward navigation button */
    public static $forwardNavButtonLocator = ['id' => "forwardNavButton"];
    /** @var string Text displayed on the button to the user */
    public static $forwardNavButtonText = "Add / Edit Elements";

    /** @var string Id of the back navigation button @deprecated */
    public static $backNavButton = "#backNavButton";
    /** @var string Id of the back navigation button */
    public static $backNavButtonLocator = ['id' => "backNavButton"];
    /** @var string Text displayed on the back button to the user */
    public static $backNavButtonText = "Edit Exam";

    #confirmation modal
    public static $confirmationModalLocator = ['class' => 'confirmationModal'];
    public static $deleteConfirmationTextId = "questionDeleteWarning";
    public static $deleteConfirmationModalText = "Warning: This will permanently delete all elements and scores associated with the question";

    public static $deleteConfirmButtonLocator = ['css' => 'button.btn.btn-danger.btn-sm.confirmQuestionDelete'];
    public static $deleteCancelButtonLocator = ['css' => '.button.btn.btn-danger.btn-sm.cancelQuestionDelete'];

    public static $deleteConfirmationModalConfirmButton = '.confirmQuestionDelete';
    public static $deleteConfirmationModalCancelButton = '.cancelQuestionDelete';
//    public static $deleteConfirmationModalConfirmButton = '/html/body/div[5]/div/div/div[3]/button[2]';
//    public static $deleteConfirmationModalCancelButton = '/html/body/div[5]/div/div/div[3]/button[1]';

public static function questionPanelId($questionNumber){
    return "questionItem{$questionNumber}";
}

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

//    /**
//     * Returns the xpath to the button for dragging and rearranging questions
//     * @param $questionNumber
//     * @return string
//     */
//    public static function moveButtonXPath($questionNumber){
//        return "//*[@id='moveQuestionButton{$questionNumber}']";
////        return "//*[@id='questionItem{$questionNumber}']/div[4]/span";
//    }


    /**
     * Returns a unique identifier of the delete button for that questionNumber
     * @param $questionNumber
     * @return array
     */
    public static function deleteButtonLocator($questionNumber){
        return ['id' => "deleteQuestionButton{$questionNumber}"];
//        return ['css' => "#questionItem{$questionNumber} > div.form-group.questionButtonArea > button"];
//        return ['css' => '#' . self::questionPanelId($questionNumber) . ' .questionButtonArea .js-remove'];


    }

    /**
     * Returns the unique locator for the move button belonging to a question
     * @param $questionNumber
     * @return array
     */
    public static function moveButtonLocator($questionNumber){
        return ['id' => "moveQuestionButton{$questionNumber}"];
//        return ['css' => '#' . self::questionPanelId($questionNumber) . ' .questionButtonArea .handle'];
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

    /* ------------------------------------ utilities ------------------ */
    public static function navigateToPage($I, $examId)
    {
        $I->test_login($I);
        $I->amOnPage("exam/{$examId}/question/edit");
        $I->waitForElement(self::$mainBodyLocator);
//        $I->waitForElement(['id' => 'scriptBox']);

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
     * If not is true, this checks whether there are no fields for the questionNumber.
     * Because the sortable buttons are identified by ids which will not be
     * distinguished if the question is new, it is optional whether to check
     * the buttons are present
     *
     * @param $I
     * @param $questionNumber
     * @param bool $not
     * @param bool $checkSortableButtons
     */
    public static function checkQuestionFieldsPresent($I, $questionNumber, $not = false, $checkSortableButtons=false)
    {
        if ( $not )
        {
            $I->expect("not to see the component fields of the element");
            $I->dontSeeElement(['xpath' => self::questionNameXPath($questionNumber)]);
            $I->dontSeeElement(['xpath' => self::questionTextXPath($questionNumber)]);
            $I->dontSeeElement(['xpath' => self::maxScoreXPath($questionNumber)]);
        } else
        {
            $I->expect("to see the component fields of the element");
            $I->seeElement(['id' => self::questionPanelId($questionNumber)]);
            $I->seeElement(['xpath' => self::questionNameXPath($questionNumber)]);
            $I->seeElement(['xpath' => self::questionTextXPath($questionNumber)]);
            $I->seeElement(['xpath' => self::maxScoreXPath($questionNumber)]);
            //buttons
            //note that any ew question's buttons will not have the right ids
            if($checkSortableButtons)
            {
                #move button
                $I->seeElement(self::moveButtonLocator($questionNumber));
                #delete button
                $I->seeElement(self::deleteButtonLocator($questionNumber));
            }
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
        $I->expectTo('see page level items');
        $I->seeInCurrentUrl("exam/{$examId}/question/edit");
        $I->seeInTitle(self::$pageTitleText);
        $I->see($examName);
        $I->seeElement(self::$addQuestionButtonLocator);

        $I->expectTo('see the correct nav buttons');
        $I->seeElement(self::$forwardNavButtonLocator);
        $I->see(self::$forwardNavButtonText);
        $I->seeElement(self::$backNavButtonLocator);
        $I->see(self::$backNavButtonText);

        $I->expectTo('see the form fields for each of the expected questions');
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

            $I->expectTo('see the question namefields');
            $I->seeElement(['xpath' => self::questionNameXPath($i)]);
            $I->seeInField(['xpath' => self::questionNameXPath($i)], $v['questionName']);

            $I->expectTo('see the question text fields');
            $I->seeElement(['xpath' => self::questionTextXPath($i)]);
            $I->seeInField(['xpath' => self::questionTextXPath($i)], $v['questionText']);

            $I->expectTo('see the max score fields');
            $I->seeElement(['xpath' => self::maxScoreXPath($i)]);
            $I->seeInField(['xpath' => self::maxScoreXPath($i)], $v['maxScore']);
        }
    }


}

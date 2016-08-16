<?php
namespace Page\setup;

class SetupExamSelectPage
{
    // include url of current page
    public static $URL = '/exam';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    #common
    public static $mainBodyLocator = ['id' => 'setupSelectExamPage'];
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

    #confirm modal
    public static $confirmModalLocator = ['class' => 'confirmationModal'];
    public static $deleteConfirmButtonLocator = ['css' => 'button.btn.confirmDelete.btn-danger.btn-sm'];
    public static $deleteCancelButtonLocator = ['css' => 'button.btn.cancelDelete.btn-default.btn-sm'];
    public static $deleteExamConfirmTextLocator = ['id' => 'confirmationModalText'];
    public static $deleteExamConfirmationText ="Warning: This will delete all associated students, scores, questions and elements. Do you wish to proceed?";


    /**
     * @var string
     * @deprecated
     */
    public static $deleteExamCancelButtonXPath = "/html/body/div[5]/div/div/div[3]/button[1]";
    /**
     * @var string
     * @deprecated
     */
    public static $deleteExamConfirmButtonXPath = "/html/body/div[5]/div/div/div[3]/button[2]";

    #messages from server
    public static $deleteExamSuccessMessage = "You have successfully deleted an exam.";
    public static $cloneExamSuccessMessage = "You successfully cloned the exam.";

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

    public static function cloneButtonLocator($examId){
        return ['id' => "cloneExamButton{$examId}"];
    }

    public static function deleteButtonLocator($examId){
        return ['id' => "deleteExamButton{$examId}"];
//        return "//*[@id='examRow{$examId}']/td[5]/a[3]";
    }

    public static function editButtonLocator($examId){
        return ['id' => "editExamButton{$examId}"];
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
    
    /* -------------------------- Tools --------------- */
    public static function navigateToPage($I){
        $I->test_login($I);
        $I->amOnPage(self::$URL);
        $I->waitForElementVisible(self::$mainBodyLocator);

    }

    /* ------------------------------------------- tests ----------------------------- */
    /**
     * Used for the exam select page on route '/exam'
     * @param $I
     * @param $id
     */
    public static function checkExamRowPresent($I, $id){
        $I->expectTo("exam term and title");
        $I->see(self::examTerm($id));
        $I->see(self::partialExamName($id));

        $I->expectTo("Check that see correct edit button");
        $I->seeLink(self::$editButtonText, 'http://localhost:8000' . self::editButtonTargetRoute($id));
        $I->seeElement(self::editButtonLocator($id));
//        $I->seeElement(self::editButtonXPath($id));

        $I->expectTo("see correct clone button");
        $I->seeLink(self::$cloneButtonText, 'http://localhost:8000' . self::cloneButtonTargetRoute($id));
        $I->seeElement(self::cloneButtonLocator($id));
//        $I->seeElement(self::cloneButtonXPath($id));

        $I->expectTo("see correct delete button");
        $I->seeElement(self::deleteButtonLocator($id));
//        $I->seeElement(self::deleteButtonXPath($id));
    }

    /**
     * For the index page displayed on route: '/exam'
     * Runs assertions to make sure see all fixed page elements, exams belonging to user, and no exams
     * not belonging to the user.
     * @param $I
     * @param $examIdsWhichShouldSee
     * @param $examIdsWhichShouldNotSee
     *
     * @todo Check exam statistics displayed properly
     */
    public static function verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee)
    {
        $I->amGoingTo("Make sure the page is intact and see all expected exams");
        $I->seeElement(self::$forwardNavButton);
        $I->seeLink(self::$forwardNavButtonText, self::forwardNavButtonTarget());

        foreach ( $examIdsWhichShouldSee as $id )
        {
            self::checkExamRowPresent($I, $id);
        }


        if ( ! empty($examIdsWhichShouldNotSee) )
        {
            $I->amGoingTo("Check that other people's exams are absent");
            foreach ( $examIdsWhichShouldNotSee as $id )
            {
                $I->amGoingTo("Check that do not see exam #{$id}'s term and title");
                $I->dontSee(self::examTerm($id));
                $I->dontSee(self::partialExamName($id));

                $I->amGoingTo("Check that do not see exam #{$id}'s edit button");
                $I->dontSeeLink(self::$editButtonText, 'http://localhost:8000' . self::editButtonTargetRoute($id));
                $I->dontSeeElement(self::editButtonXPath($id));

                $I->amGoingTo("Check that do not see exam #{$id} clone button");
                $I->dontSeeLink(self::$cloneButtonText, 'http://localhost:8000' . self::cloneButtonTargetRoute($id));
                $I->dontSeeElement(self::cloneButtonXPath($id));

                $I->amGoingTo("Check that do not see exam #{$id} delete button");
                $I->dontSeeElement(self::deleteButtonXPath($id));
            }
        }
    }

}

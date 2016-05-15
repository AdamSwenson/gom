<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Question;
use Faker\Factory;
use Page\ElementEditPage;
use Page\GradeSelectExamPage;
use Page\QuestionEditPage;
use Page\RosterEditPage;
use Page\SetupExamSelectPage;

class Acceptance extends \Codeception\Module
{


    public static $examWith5QuestionsId = 1;
    public static $examWithNoQuestionsId = 4;


    public function examIdWithQuestions()
    {
        return self::$examWith5QuestionsId;
    }

    public function examIdNoQuestions()
    {
        return self::$examWithNoQuestionsId;
    }


//    /**
//     * Returns the locator for a standard bootbox confirmation
//     * modal's confirm button.
//     * @return array
//     */
//    public function bootboxConfirmButtonLocator()
//    {
//        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-primary'];
//    }
//
//    /**
//     * Returns the locator for a standard bootbox confirmation modal's
//     * cancel button
//     * @return array
//     */
//    public function bootboxCancelButtonLocator()
//    {
//        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-default'];
//    }
//
//
//    /**
//     * If using a standard bootbox confirm dialog, this will wait
//     * for the modal to display and make sure that the main divs
//     * are present.
//     *
//     * Optionally, it will check for the presence of cancel and
//     * confirm buttons.
//     *
//     * It can also wait for the modal to disappear and check that it's gone.
//     *
//     * @param $I
//     * @param bool $expectButtons
//     * @param bool $waitForDisappear If true, waits and checks that modal disappeared
//     */
//    public function waitForBootboxModal($I, $expectButtons = false, $waitForDisappear = false){
//        if( ! $waitForDisappear){
//            $I->expect("the standard bootbox confirmation modal to appear");
//            $I->waitForElementVisible(['css' => '.modal-content']);
//            $I->seeElement(['css' => '.modal-content .modal-body']);
//
//            if($expectButtons){
//                $I->expectTo("see the standard bootbox confirm and cancel buttons");
//                $I->seeElement($this->bootboxCancelButtonLocator());
//                $I->seeElement($this->bootboxConfirmButtonLocator());
//            }
//        }
//        else{
//            $I->expect("the standard bootbox confirmation modal to disappear");
//            $I->waitForElementNotVisible(['css' => '.modal-content']);
//            $I->dontSeeElement(['css' => '.modal-content .modal-body']);
//            if($expectButtons){
//                $I->expectTo("the standard bootbox confirm and cancel buttons to disappear");
//                $I->dontSeeElement($I->bootboxCancelButtonLocator());
//                $I->dontSeeElement($I->bootboxConfirmButtonLocator());
//            }
//        }
//    }

    /**
     * Creates test data for questions.
     * Returns array with questionNumbers as keys. Each key has an array
     * of data with keys: name, text, maxScore
     * @param int $numberOfQuestions Number of questions to create data for
     * @return array
     */
    public function generateQuestionTestData($numberOfQuestions)
    {
        $testData = [];
        $Faker = Factory::create();
        for ( $i = 1; $i <= $numberOfQuestions; $i++ )
        {
            $testData[ $i ] = [
                'name'     => $Faker->text(30),
                'text'     => $Faker->text(30),
                'maxScore' => $Faker->numberBetween(1, 1000),
            ];
        }

        return $testData;
    }

    /* -------------------------------- Element pages -------------------- */


    /**
     * Creates test data for elements.
     * Keys: name, text, missing, poor, fair, excellent
     * @param $numberOfElements
     * @return array
     */
    public function generateElementTestData($numberOfElements)
    {
        $testData = [];
        $Faker =
        $Faker = Factory::create();
        for ( $i = 1; $i <= $numberOfElements; $i++ )
        {
            $testData[ $i ] = [
                'name'      => $Faker->text(30),
                'text'      => $Faker->text(30),
                'missing'   => $Faker->text(30),
                'poor'      => $Faker->text(30),
                'fair'      => $Faker->text(30),
                'excellent' => $Faker->text(30),
            ];
        }

        return $testData;
    }



//    /**
//     * Checks whether the fields for creating or editing a given question number are present.
//     * If not is true, this checks whether there are no fields for the questionNumber
//     * @param $I
//     * @param $questionNumber
//     * @param bool $not
//     */
//    public function checkQuestionFieldsPresent($I, $questionNumber, $not = false)
//    {
//        if ( $not )
//        {
//            $I->dontSeeElement(QuestionEditPage::questionNameXPath($questionNumber));
//            $I->dontSeeElement(QuestionEditPage::questionTextXPath($questionNumber));
//            $I->dontSeeElement(QuestionEditPage::maxScoreXPath($questionNumber));
//        } else
//        {
//            $I->seeElement(QuestionEditPage::questionNameXPath($questionNumber));
//            $I->seeElement(QuestionEditPage::questionTextXPath($questionNumber));
//            $I->seeElement(QuestionEditPage::maxScoreXPath($questionNumber));
//            //buttons
//            $I->seeElement(QuestionEditPage::deleteButtonXPath($questionNumber));
//            $I->seeElement(QuestionEditPage::moveButtonXPath($questionNumber));
//        }
//    }

//    /**
//     * Returns array with keys questionName, questionText, maxScore
//     * @param $examId
//     * @param $questionNumber
//     * @return array
//     */
//    public function getQuestionFieldsInitialValues($examId, $questionNumber)
//    {
//        return [
//            'questionName' => "Exam{$examId}Question{$questionNumber}",
//            'questionText' => "Exam{$examId}Question{$questionNumber} Text.",
//            'maxScore'     => 100,
//        ];
//    }

//    /**
//     * Runs tests for page title, page heading, appropriate navs, and question fields
//     * @param $I
//     * @param $examId
//     * @param $examName
//     * @param $numberQuestions
//     */
//    public function verifyQuestionEditPageIntact($I, $examId, $examName, $numberQuestions)
//    {
//        $I->amGoingTo("Check that everything is displayed properly");
//        $I->seeInCurrentUrl("exam/{$examId}/question/edit");
//        $I->seeInTitle(QuestionEditPage::$pageTitleText);
//        $I->see($examName);
//        $I->seeElement(QuestionEditPage::$addQuestionButtonId);
//        //correct navs
//        $I->seeElement(QuestionEditPage::$forwardNavButton);
//        $I->seeElement(QuestionEditPage::$backNavButton);
//        //fields present
//        for ( $i = 1; $i <= $numberQuestions; $i++ )
//        {
//            $I->checkQuestionFieldsPresent($I, $i);
//        }
//    }

//    public function verifyQuestionsHaveInitialExpectedValues($I, $examId, $numberQuestions)
//    {
//        $I->amGoingTo("Check that the questions have the expected text");
//        for ( $i = 1; $i <= $numberQuestions; $i++ )
//        {
//            $v = $I->getQuestionFieldsInitialValues($examId, $i);
//            //question name
//            $I->seeElement(QuestionEditPage::questionNameXPath($i));
//            $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
//            //question text
//            $I->seeElement(QuestionEditPage::questionTextXPath($i));
//            $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
//            //max score
//            $I->seeElement(QuestionEditPage::maxScoreXPath($i));
//            $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
//        }
//    }




//
//    /**
//     * Checks whether the fields for creating or editing a given element are present.
//     * If not is true, this checks whether there are no fields for the subtask
//     * @param $I
//     * @param int $subtask
//     * @param bool $not
//     */
//    public function checkElementFieldsPresent($I, $subtask, $not = false)
//    {
//        if ( $not )
//        {
//            $I->dontSeeElement(ElementEditPage::elementItemXPath($subtask));
//            $I->dontSeeElement(ElementEditPage::elementNameXPath($subtask));
//            $I->dontSeeElement(ElementEditPage::elementTextXPath($subtask));
//            $I->dontSeeElement(ElementEditPage::customizeResponsesButtonXPath($subtask));
//            $I->dontSeeElement(ElementEditPage::commentFormXPath($subtask));
//        } else
//        {
//            $I->seeElement(ElementEditPage::elementItemXPath($subtask));
//            $I->seeElement(ElementEditPage::elementNameXPath($subtask));
//            $I->seeElement(ElementEditPage::elementTextXPath($subtask));
//            $I->seeElement(ElementEditPage::customizeResponsesButtonXPath($subtask));
//            // $I->seeElement(ElementEditPage::commentFormXPath($subtask));
//        }
//    }

//    /**
//     * Runs tests for page title, page heading, appropriate navs, and element fields
//     * @param $I
//     * @param $examId
//     * @param $questionId
//     * @param $numberOfElements
//     */
//    public function verifyElementEditPageIntact($I, $examId, $questionId, $numberOfElements)
//    {
//        $I->amGoingTo("Check that everything on the element editing page is displayed properly");
//        //page level text
//        $I->seeInTitle(ElementEditPage::$pageTitleText);
//        $I->see(ElementEditPage::pageHeadingText($examId, $questionId));
//        //page level buttons
//        $I->seeElement(ElementEditPage::$addElementButtonXPath);
//        //correct navs
//        $I->seeElement(ElementEditPage::$forwardNavButton);
//        $I->seeElement(ElementEditPage::$backNavButton);
//        //fields present
//        for ( $i = 1; $i <= $numberOfElements; $i++ )
//        {
//            $I->checkElementFieldsPresent($I, $i);
//        }
//
//    }

    /* -------------------------------- Rosters --------------------- */
//
//    public function verifyRosterEditPageIntact($I)
//    {
//        $I->amGoingTo("Check that the page is in its initial state and everything is displayed as expected");
//        $I->seeInTitle(RosterEditPage::$pageTitleText);
//
//        //correct navs
//        $I->seeElement(RosterEditPage::$forwardNavButton);
//        $I->see(RosterEditPage::$forwardNavText, RosterEditPage::$forwardNavXPath);
//        $I->seeElement(RosterEditPage::$backNavButton);
//        $I->see(RosterEditPage::$backNavText, RosterEditPage::$backNavXPath);
//    }

    /* ---------------------------------- Exam selection ----- */
//    /**
//     * Used for the exam select page on route '/exam'
//     * @param $I
//     * @param $id
//     */
//    public function checkExamRowPresent($I, $id){
//        $I->amGoingTo("Check that see exam term and title");
//        $I->see(SetupExamSelectPage::examTerm($id));
//        $I->see(SetupExamSelectPage::partialExamName($id));
//
//        $I->amGoingTo("Check that see correct edit button");
//        $I->seeLink(SetupExamSelectPage::$editButtonText, 'http://localhost:8000' . SetupExamSelectPage::editButtonTargetRoute($id));
//        $I->seeElement(SetupExamSelectPage::editButtonXPath($id)
//            , [
////        'title' => SetupExamSelectPage::$editButtonTitle,
////        'href'  => 'http://localhost:8000' . SetupExamSelectPage::editButtonTargetRoute($id),
////        'class' => SetupExamSelectPage::$editButtonClass . ' btn btn-info',
//                       ]
//        );
//
//        $I->amGoingTo("Check that see correct clone button");
//        $I->seeLink(SetupExamSelectPage::$cloneButtonText, 'http://localhost:8000' . SetupExamSelectPage::cloneButtonTargetRoute($id));
//        $I->seeElement(SetupExamSelectPage::cloneButtonXPath($id)
////        , [
////        'title' => SetupExamSelectPage::$cloneButtonTitle,
////        'href'  => 'http://localhost:8000' . SetupExamSelectPage::cloneButtonTargetRoute($id),
//////        'class' => SetupExamSelectPage::$cloneButtonClass . ' btn btn-default',
////    ]
//        );
//
//        $I->amGoingTo("Check that see correct delete button");
//        $I->seeElement(SetupExamSelectPage::deleteButtonXPath($id)
////        , [
////        'title' => SetupExamSelectPage::$deleteButtonTitle,
////        'class' => SetupExamSelectPage::$deleteButtonClass . ' btn btn-danger',
////    ]
//        );
//    }
//
//    /**
//     * For the index page displayed on route: '/exam'
//     * Runs assertions to make sure see all fixed page elements, exams belonging to user, and no exams
//     * not belonging to the user.
//     * @param $I
//     * @param $examIdsWhichShouldSee
//     * @param $examIdsWhichShouldNotSee
//     *
//     * @todo Check exam statistics displayed properly
//     */
//    public function verifySetupExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee)
//    {
//        $I->amGoingTo("Make sure the page is intact and see all expected exams");
//        $I->seeElement(SetupExamSelectPage::$forwardNavButton);
//        $I->seeLink(SetupExamSelectPage::$forwardNavButtonText, SetupExamSelectPage::forwardNavButtonTarget());
//
//        foreach ( $examIdsWhichShouldSee as $id )
//        {
//            $I->checkExamRowPresent($I, $id);
//        }
//
//
//        if ( ! empty($examIdsWhichShouldNotSee) )
//        {
//            $I->amGoingTo("Check that other people's exams are absent");
//            foreach ( $examIdsWhichShouldNotSee as $id )
//            {
//                $I->amGoingTo("Check that do not see exam #{$id}'s term and title");
//                    $I->dontSee(SetupExamSelectPage::examTerm($id));
//                    $I->dontSee(SetupExamSelectPage::partialExamName($id));
//
//                $I->amGoingTo("Check that do not see exam #{$id}'s edit button");
//                    $I->dontSeeLink(SetupExamSelectPage::$editButtonText, 'http://localhost:8000' . SetupExamSelectPage::editButtonTargetRoute($id));
//                    $I->dontSeeElement(SetupExamSelectPage::editButtonXPath($id));
//
//                $I->amGoingTo("Check that do not see exam #{$id} clone button");
//                    $I->dontSeeLink(SetupExamSelectPage::$cloneButtonText, 'http://localhost:8000' . SetupExamSelectPage::cloneButtonTargetRoute($id));
//                    $I->dontSeeElement(SetupExamSelectPage::cloneButtonXPath($id));
//
//                $I->amGoingTo("Check that do not see exam #{$id} delete button");
//                    $I->dontSeeElement(SetupExamSelectPage::deleteButtonXPath($id));
//            }
//        }
//    }


    /* ---------------------------------------------- Grade exam --------------------------------- */
//    public function checkExamRowPresentForGradeExamSelectPage($I, $examId){
//            $I->amGoingTo("Check that see exam #{$examId}term and title");
//            $I->see(GradeSelectExamPage::examTerm($examId));
//            $I->see(GradeSelectExamPage::partialExamName($examId));
//
//            $I->amGoingTo("Check that see correct grade button for exam #{$examId}");
//            $I->seeLink(GradeSelectExamPage::$gradeButtonText, GradeSelectExamPage::gradeButtonTargetRoute($examId));
//            $I->seeElement(GradeSelectExamPage::gradeButtonXPath($examId)
//                , [
////        'title' => SetupExamSelectPage::$editButtonTitle,
////        'class' => SetupExamSelectPage::$editButtonClass . ' btn btn-info',
//                ]
//            );
//
//            $I->amGoingTo("Check that see correct assign button for exam #{$examId}");
//            $I->seeLink(GradeSelectExamPage::$assignButtonText, GradeSelectExamPage::assignButtonTargetRoute($examId));
//            $I->seeElement(GradeSelectExamPage::assignButtonXPath($examId)
////        , [
////        'title' => SetupExamSelectPage::$cloneButtonTitle,
//////        'class' => SetupExamSelectPage::$cloneButtonClass . ' btn btn-default',
////    ]
//            );
//
//
//    }
//
//    /**
//     * For the index page displayed on route: '/grade'
//     * Runs assertions to make sure see all fixed page elements, exams belonging to user, and no exams
//     * not belonging to the user.
//     * @param $I
//     * @param $examIdsWhichShouldSee
//     * @param $examIdsWhichShouldNotSee
//     *
//     * @todo Check exam statistics displayed properly
//     */
//    public function verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee){
//        $I->amGoingTo("Make sure the page is intact and see all expected exams");
//
//        foreach ( $examIdsWhichShouldSee as $id )
//        {
//            $I->checkExamRowPresentForGradeExamSelectPage($I, $id);
//        }
//
//        if ( ! empty($examIdsWhichShouldNotSee) )
//        {
//            $I->amGoingTo("Check that other people's exams are absent");
//            foreach ( $examIdsWhichShouldNotSee as $id )
//            {
//                $I->amGoingTo("Check that do not see exam #{$id}'s term and title");
//                $I->dontSee(GradeSelectExamPage::examTerm($id));
//                $I->dontSee(GradeSelectExamPage::partialExamName($id));
//
//                $I->amGoingTo("Check that do not see exam #{$id}'s grade button");
//                $I->dontSeeLink(GradeSelectExamPage::$gradeButtonText,GradeSelectExamPage::gradeButtonTargetRoute($id, true));
//                $I->dontSeeElement(GradeSelectExamPage::gradeButtonXPath($id));
//
//                $I->amGoingTo("Check that do not see exam #{$id} assign button");
//                $I->dontSeeLink(GradeSelectExamPage::$assignButtonText, GradeSelectExamPage::assignButtonTargetRoute($id, true));
//                $I->dontSeeElement(GradeSelectExamPage::assignButtonXPath($id));
//
//            }
//        }
//    }

}



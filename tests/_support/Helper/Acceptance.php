<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Faker\Factory;
use Page\ElementEditPage;
use Page\QuestionEditPage;
use Page\RosterEditPage;

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
            $I->dontSeeElement(QuestionEditPage::questionNameXPath($questionNumber));
            $I->dontSeeElement(QuestionEditPage::questionTextXPath($questionNumber));
            $I->dontSeeElement(QuestionEditPage::maxScoreXPath($questionNumber));
        } else
        {
            $I->seeElement(QuestionEditPage::questionNameXPath($questionNumber));
            $I->seeElement(QuestionEditPage::questionTextXPath($questionNumber));
            $I->seeElement(QuestionEditPage::maxScoreXPath($questionNumber));
        }
    }

    /**
     * Returns array with keys questionName, questionText, maxScore
     * @param $examId
     * @param $questionNumber
     * @return array
     */
    public function getQuestionFieldsInitialValues($examId, $questionNumber)
    {
        return [
            'questionName' => "Exam{$examId}Question{$questionNumber}",
            'questionText' => "Exam{$examId}Question{$questionNumber} Text.",
            'maxScore'     => 100,
        ];
    }

    /**
     * Runs tests for page title, page heading, appropriate navs, and question fields
     * @param $I
     * @param $examName
     * @param $numberQuestions
     */
    public function verifyQuestionEditPageIntact($I, $examName, $numberQuestions)
    {
        $I->amGoingTo("Check that everything is displayed properly");
        $I->seeInTitle(QuestionEditPage::$pageTitleText);
        $I->see($examName);
        $I->seeElement(QuestionEditPage::$addQuestionButtonId);
        //correct navs
        $I->seeElement(QuestionEditPage::$forwardNavButton);
        $I->seeElement(QuestionEditPage::$backNavButton);
        //fields present
        for ( $i = 1; $i <= $numberQuestions; $i++ )
        {
            $I->checkQuestionFieldsPresent($I, $i);
        }
    }

    public function verifyQuestionsHaveInitialExpectedValues($I, $examId, $numberQuestions)
    {
        $I->amGoingTo("Check that the questions have the expected text");
        for ( $i = 1; $i <= $numberQuestions; $i++ )
        {
            $v = $I->getQuestionFieldsInitialValues($examId, $i);
            $I->seeElement(QuestionEditPage::questionNameXPath($i));
            $I->seeInField(QuestionEditPage::questionNameXPath($i), $v['questionName']);
            $I->seeElement(QuestionEditPage::questionTextXPath($i));
            $I->seeInField(QuestionEditPage::questionTextXPath($i), $v['questionText']);
            $I->seeElement(QuestionEditPage::maxScoreXPath($i));
            $I->seeInField(QuestionEditPage::maxScoreXPath($i), $v['maxScore']);
        }
    }

    /**
     * Creates test data for questions.
     * Returns array with questionNumbers as keys. Each key has an array
     * of data with keys: name, text, maxScore
     * @param int $numberOfQuestions Number of questions to create data for
     * @return array
     * @internal param $numberOfElements
     */
    public function generateQuestionTestData($numberOfQuestions)
    {
        $testData = [];
        $Faker = Factory::create();
        for ( $i = 1; $i <= $numberOfQuestions; $i++ )
        {
            $testData[ $i ] = [
                'name'      => $Faker->text(30),
                'text'      => $Faker->text(30),
                'maxScore'   => $Faker->numberBetween(1,1000)
            ];
        }

        return $testData;
    }


    /* -------------------------------- Element pages -------------------- */

    /**
     * Checks whether the fields for creating or editing a given element are present.
     * If not is true, this checks whether there are no fields for the subtask
     * @param $I
     * @param int $subtask
     * @param bool $not
     */
    public function checkElementFieldsPresent($I, $subtask, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(ElementEditPage::elementItemXPath($subtask));
            $I->dontSeeElement(ElementEditPage::elementNameXPath($subtask));
            $I->dontSeeElement(ElementEditPage::elementTextXPath($subtask));
            $I->dontSeeElement(ElementEditPage::customizeResponsesButtonXPath($subtask));
            $I->dontSeeElement(ElementEditPage::commentFormXPath($subtask));
        } else
        {
            $I->seeElement(ElementEditPage::elementItemXPath($subtask));
            $I->seeElement(ElementEditPage::elementNameXPath($subtask));
            $I->seeElement(ElementEditPage::elementTextXPath($subtask));
            $I->seeElement(ElementEditPage::customizeResponsesButtonXPath($subtask));
            // $I->seeElement(ElementEditPage::commentFormXPath($subtask));
        }
    }

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

    /**
     * Runs tests for page title, page heading, appropriate navs, and element fields
     * @param $I
     * @param $examId
     * @param $questionId
     * @param $numberOfElements
     */
    public function verifyElementEditPageIntact($I, $examId, $questionId, $numberOfElements)
    {
        $I->amGoingTo("Check that everything on the element editing page is displayed properly");
        //page level text
        $I->seeInTitle(ElementEditPage::$pageTitleText);
        $I->see(ElementEditPage::pageHeadingText($examId, $questionId));
        //page level buttons
        $I->seeElement(ElementEditPage::$addElementButtonXPath);
        //correct navs
        $I->seeElement(ElementEditPage::$forwardNavButton);
        $I->seeElement(ElementEditPage::$backNavButton);
        //fields present
        for ( $i = 1; $i <= $numberOfElements; $i++ )
        {
            $I->checkElementFieldsPresent($I, $i);
        }

    }

    /* -------------------------------- Rosters --------------------- */

    public function verifyRosterEditPageIntact($I){
        $I->amGoingTo("Check that the page is in its initial state and everything is displayed as expected");
        $I->seeInTitle(RosterEditPage::$pageTitleText);
        
        //correct navs
        $I->seeElement(RosterEditPage::$forwardNavButton);
        $I->see(RosterEditPage::$forwardNavText, RosterEditPage::$forwardNavXPath);
        $I->seeElement(RosterEditPage::$backNavButton);
        $I->see(RosterEditPage::$backNavText, RosterEditPage::$backNavXPath);
    }
}

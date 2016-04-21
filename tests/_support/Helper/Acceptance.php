<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{


public static $examWith5QuestionsId = 1;
public static $examWithNoQuestionsId = 4;


    public function examIdWithQuestions(){
        return self::$examWith5QuestionsId;
    }

    public function examIdNoQuestions(){
        return self::$examWithNoQuestionsId;
    }

    /**
     * Checks whether the fields for creating or editing a given question number are present.
     * If not is true, this checks whether there are no fields for the questionNumber
     * @param $I
     * @param $questionNumber
     * @param bool $not
     */
    public function checkQuestionFieldsPresent($I, $questionNumber, $not=false){
        if($not){
            $I->dontSeeElement(QuestionEditPage::questionNameXPath($questionNumber));
            $I->dontSeeElement(QuestionEditPage::questionTextXPath($questionNumber));
            $I->dontSeeElement(QuestionEditPage::maxScoreXPath($questionNumber));
        }else{
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
            'questionText' => "Exam{$examId}Question{$questionNumber} Text",
            'maxScore'     => 100,
        ];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 4:34 PM
 */

namespace App\classes\ScoreClasses;

/**
 * Class ScoreLoader
 * This gets the questions, elements, and scores for use in  grading.
 * It repackages everything to have the fields expected by the javascript
 *
 * @package ScoreClasses
 */
class ScoreLoader
{

    public $to_send = array();

    public $elements_to_send = array();

    public $questions_to_send = array();

    /** @var  $question_score_handler  \App\classes\ScoreClasses\IQuestionScoreHandler */
    public $question_score_handler;

    /** @var  $element_score_handler \App\classes\ScoreClasses\IElementScoreHandler */
    public $element_score_handler;

    public function set_question_score_handler(\App\classes\ScoreClasses\IQuestionScoreHandler $question_score_handler)
    {
        $this->question_score_handler = $question_score_handler;
    }

    public function set_element_score_handler(\App\classes\ScoreClasses\IElementScoreHandler $element_score_handler)
    {
        $this->element_score_handler = $element_score_handler;
    }

    protected function get_questions(\Exam $exam, \Question $question)
    {
        return \QuestionAssignerQuery::create()->filterByExam($exam)->filterByQuestion($question)->findOneOrCreate();
    }


    protected function get_elements(\Exam $exam, \Question $question)
    {
        $element_assignments = \ElementAssignmentQuery::create()
            ->filterByExam($exam)
            ->filterByQuestion($question)
            ->find();
        return $element_assignments;

        //        $q = \ElementAssignmentQuery::create()
//            ->filterByExam($exam)
//            ->filterByQuestion($question)
//            ->useElementQuery()
//            ->useElementScoreQuery()
//            ->filterByStudent($student)
//            ->endUse()
//            ->endUse()
//            ->useQuestionQuery()
//            ->useQuestionScoreQuery()
//            ->filterByStudent($student)
//            ->endUse()
//            ->endUse()
//            ->find();

            // ->with('Element')
//            ->addJoinCondition('ElementScore.sid = ?', $student->getId())
//            ->joinWith('ElementScore.elementScore')
//            ->where('ElementScore.sid = ?', $student->getId())
            // ->useQuestionQuery()
//            ->with('elements')
            //->with('questions.questionText')
            //->endUse()
//            ->with('Question')
//            ->with('Element')

    }

    /**
     * Loads element scores for elements associated with teh question.
     * Note the returned array ($currentQscores) is for use by the backup function
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_element_scores(\Exam $exam, \Question $question, \Student $student)
    {
        $qa = $this->get_questions($exam, $question);
        $element_assignments = $this->get_elements($exam, $question);
        $currentQscores = array();
        if (isset($element_assignments)) {
            foreach ($element_assignments as $ea) {
                $element = $ea->getElement();
                $es = $this->element_score_handler->load($exam, $element, $student);
                $score = $es ? $es->getElementscore() : '';
                $e = array('elementID' => $element->getId(),
                    'questionNumber' => $qa->getQuestionnumber(),
                    'elementAbbr' => $element->getElementname(),
                    'elementEnglish' => $element->getDisplaytext(),
                    'elementScore' => $score);
                array_push($this->elements_to_send, $e);
                array_push($currentQscores, $e);
            }
            return $currentQscores;
        }
    }

    /**
     * Loads question scores.
     * The returned array is for use by the backup function.
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return array
     */
    protected function load_question_scores(\Exam $exam, \Question $question, \Student $student)
    {
        $qa = $this->get_questions($exam, $question);
        $qs = $this->question_score_handler->load($exam, $question, $student);
        $q = array('questionID' => $question->getId(),
            'questionNumber' => $qa->getQuestionnumber(),
            'questionTitle' => $question->getQuestiontext(),
            'questionScore' => $qs->getQuestionscore());
        array_push($this->questions_to_send, $q);
        return $q;
    }

    /**
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load(\Exam $exam, \Question $question, \Student $student)
    {
        $this->load_element_scores($exam, $question, $student);
        $this->load_question_scores($exam, $question, $student);
        $out = array('questions' => $this->questions_to_send, 'elements' => $this->elements_to_send);
        return $out;
    }

    /**
     * Returns in proper format for backup operations
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return array
     */
    public function loadForBackup(\Exam $exam, \Question $question, \Student $student)
    {
        $questionScores = $this->load_question_scores($exam, $question, $student);
        $elementScores = $this->load_element_scores($exam, $question, $student);
        $qkey = "(Q{$questionScores['questionNumber']}) {$questionScores['questionTitle']}";
        $out = array($qkey => $questionScores['questionScore']);
        foreach($elementScores as $e){
            $out[$e['elementAbbr']] = $e['elementScore'];
        }
        return $out;
    }


}
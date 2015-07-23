<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\ScoreClasses;

/**
 * Handles all calls to the db for a student's scores
 *
 * @author adam
 */
class OutputScoreDAO implements IOutputScoreDAO
{

    public function all_question_scores(\Exam $exam, \Student $student)
    {
        return \QuestionScoreQuery::create()
            ->filterByExam($exam)
            ->filterByStudent($student)
                ->useQuestionQuery()
                    ->useQuestionAssignerQuery()
                        ->orderByQuestionnumber()
                    ->endUse()
                ->endUse()
            ->find();

    }

    public function particular_question_score(\Exam $exam, \Student $student, \Question $question)
    {
        return \QuestionScoreQuery::create()
            ->filterByExam($exam)
            ->filterByStudent($student)
            ->filterByQuestion($question)
            ->find();
    }

    public function all_element_scores(\Exam $exam, \Student $student)
    {
        return \ElementScoreQuery::create()
            ->filterByExam($exam)
            ->filterByStudent($student)
            ->find();
    }

    public function particular_element_score($exam, $student, $element)
    {

    }

    public function get_comments(\Exam $exam, \Student $student)
    {
$this->query = "SELECT c.content, qa.questionNumber, es.elementScore, elementID, exq.subtask
			FROM comments c
			NATURAL JOIN elementScores es
			NATURAL JOIN commentAssigner ca
			NATURAL JOIN questionAssigner qa
			NATURAL JOIN elementsXquestions exq
			WHERE examID = :examID
			AND sid = :sid
			AND ca.elementID = exq.elementID
			AND (SELECT elementScore
				FROM elementScores
				WHERE examID = :examID
				AND sid = :sid
				AND elementID = exq.elementID)
			BETWEEN ca.minScore AND ca.maxScore
			ORDER BY questionNumber, subtask";
        $this->vals = array('examID' => $exam->displayID(), 'sid' => $student->displayID());
        $this->returnAssocAll();

        return $this->resultAssoc;
        /*
        //The below query requires that a class be set in the incoming student
        $this->query = "SELECT c.content, qa.questionNumber, es.elementScore, elementID, exq.subtask
			FROM comments c
			NATURAL JOIN elementScores es
			NATURAL JOIN commentAssigner ca
			NATURAL JOIN questionAssigner qa
			NATURAL JOIN elementsXquestions exq
			WHERE classID = :classID
			AND examID = :examID
			AND sid = :sid
			AND ca.elementID = exq.elementID
			AND (SELECT elementScore
				FROM elementScores
				WHERE examID = :examID
				AND sid = :sid
				AND elementID = exq.elementID)
			BETWEEN ca.minScore AND ca.maxScore
			ORDER BY questionNumber, subtask";
        $this->vals = array('classID' => $student->displayClass(), 'examID' => $exam->displayID(), 'sid' => $student->displayID());
         *
         */
        /* this also doesn't work
         * SELECT c.content, qa.questionNumber, es.elementScore, es.elementID, exq.subtask
			FROM  elementsXquestions exq
			INNER JOIN elementScores es ON exq.elementID = exq.elementID
			INNER JOIN commentAssigner ca ON ca.elementID = exq.elementID
			INNER JOIN comments c ON ca.commentID = c.commentID
			INNER JOIN questionAssigner qa ON qa.questionID = exq.questionID
			WHERE exq.examID = 1
			AND es.examID = 1
			AND ca.examID = 1
			AND qa.examID = 1
			AND sid = 101299872
			AND ca.elementID = exq.elementID
			AND (SELECT ess.elementScore
				FROM elementScores ess
				WHERE ess.examID = 1
				AND ess.sid = 101299872
				AND ess.elementID = exq.elementID)
			BETWEEN ca.minScore AND ca.maxScore
			ORDER BY questionNumber, subtask;

         */

    }

}

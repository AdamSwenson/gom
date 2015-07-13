<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\dao;

use Map\ElementScoresTableMap;
use Propel\Runtime\Formatter\ObjectFormatter;
use Propel\Runtime\Propel;

/**
 * Handles all data retrieval for student data
 *
 * @author adam
 */
class OutputDataAccess implements IOutputDataAccess
{

    protected $question_assign_dao;
    protected $questions;

    public function set_question_dao(\App\classes\QuestionClasses\dao\IQuestionAssignmentDAO $questionAssignmentDAO)
    {
        $this->question_assign_dao = $questionAssignmentDAO;
    }


    /**
     * @param \Exam $exam
     * @return mixed
     */
    public function get_questions_for_exam(\Exam $exam)
    {
        $this->questions = $this->question_assign_dao->load_for_exam($exam);
        return $this->questions;
    }

    public function get_student_score_and_item_for_question(\ExaminationClasses\models\IExam $exam, $student, $questionID)
    {
        $this->query = "SELECT e.elementID, e.elementAbbr, exq.subtask, e.elementEnglish,
                    (SELECT questionNumber FROM questionAssigner WHERE examID = :examID AND questionID = :questionID) AS questionNumber, e.elementID AS eid,
                    (SELECT elementScore AS elementScore
                    FROM elementScores WHERE examID = :examID
                    AND sid = :sid
                    AND elementID = eid ) AS elementScore
                    FROM elements e
                    INNER JOIN elementsXquestions exq ON e.elementID = exq.elementID
                    WHERE exq.examID = :examID AND exq.questionID = :questionID";
        $this->vals = array('examID' => $exam->displayID(), 'sid' => $student->displayID(), 'questionID' => $questionID);
        $this->returnAssocAll();

        return $this->resultAssoc;
    }

    public function element_averages(\ExaminationClasses\models\IExam $exam)
    {

        $this->query = "SELECT AVG(elementScore) AS elementAverage, elementID, elementAbbr, questionNumber
			FROM elementScores
			NATURAL JOIN elements
			NATURAL JOIN questionAssigner
			NATURAL JOIN elementsXquestions
			WHERE examID = :examID
			GROUP BY questionNumber, elementAbbr";
//            "SELECT AVG(elementScore) AS elementAverage, elementID, elementAbbr, questionNumber
//			FROM elementScores es
//			INNER JOIN elements e USING(elementID)
//			INNER JOIN questionAssigner qa USING(questionID)
//			INNER JOIN elementsXquestions exq USING(elementID)
//			WHERE examID = :examID
//			GROUP BY questionNumber, elementAbbr""
        $this->vals = array('examID' => $exam->displayID());
        $this->returnAssocAll();

        return $this->resultAssoc;
    }

    public function question_averages(\ExaminationClasses\models\IExam $exam)
    {
        $this->query = "SELECT AVG(qs.questionScore) AS questionAverage, qs.questionID, qa.questionNumber
				FROM questionScores qs
				INNER JOIN questionAssigner qa ON qs.questionID = qa.questionID
				WHERE qs.examID = :examID
				GROUP BY questionNumber
                ORDER BY questionNumber ASC";
        $this->vals = array('examID' => $exam->displayID());
        $this->returnAssocAll();

        return $this->resultAssoc;
    }

}

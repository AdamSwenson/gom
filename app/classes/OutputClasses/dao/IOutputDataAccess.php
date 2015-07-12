<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace OutputClasses\dao;

/**
 * The methods expected by classes calling outputdataaccess
 * @author adam
 */
interface IOutputDataAccess
{
    public function set_question_dao(\QuestionClasses\dao\IQuestionAssignmentDAO $questionAssignmentDAO);

    public function get_questions_for_exam(\Exam $exam);

   // public function get_student_score_and_item_for_question(\ExaminationClasses\Examination $exam, \StudentClasses\models\Student $student, $question);


    public function element_averages(\ExaminationClasses\models\IExam $exam);

    public function question_averages(\ExaminationClasses\models\IExam $exam);

}

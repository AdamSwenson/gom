<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class StoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $assign_element = <<<MYSQL
    DROP PROCEDURE IF EXISTS assign_element;
    CREATE PROCEDURE `assign_element` (IN questionAssignmentId INT, IN subtask INT, IN elementId INT)
    BEGIN
        INSERT INTO element_assignments (question_assignment_id, subtask, element_id)
        VALUES (questionAssignmentId, subtask, elementId) ON DUPLICATE KEY UPDATE element_id = elementId;

        SELECT question_assignment_id, subtask, element_id FROM element_assignments
        WHERE question_assignment_id = questionAssignmentId AND subtask = subtask AND element_id = elementId;
    END
MYSQL;
        DB::unprepared($assign_element);

        $assign_question = <<<MYSQL
DROP PROCEDURE IF EXISTS assign_question;
CREATE PROCEDURE `assign_question` (IN questionId INT, IN examId INT, IN questionNumber INT)
  BEGIN
    INSERT INTO question_assignments (question_id, exam_id, question_number)
    VALUES (questionId, examId, questionNumber)
    ON DUPLICATE KEY UPDATE question_id = questionId;
  END
MYSQL;
        DB::unprepared($assign_question);

        $record_question_score = <<<MYSQL
DROP PROCEDURE IF EXISTS record_question_score;
CREATE PROCEDURE `record_question_score`(IN questionAssignmentId INT, IN studentId INT, IN score FLOAT)
  BEGIN
  INSERT INTO question_scores (question_assignment_id, student_id, score)
  VALUES (questionAssignmentId, studentId, score)
  ON DUPLICATE KEY UPDATE score = score;
END
MYSQL;
        DB::unprepared($record_question_score);


        $record_element_score = <<<MYSQL
DROP PROCEDURE IF EXISTS record_element_score;
CREATE PROCEDURE `record_element_score`(IN elementAssignmentId INT, IN studentId INT, IN score FLOAT)
  BEGIN
    INSERT INTO element_scores (element_assignment_id, student_id, score)
    VALUES (elementAssignmentId, studentId, score)
    ON DUPLICATE KEY UPDATE score = score;
  END;
MYSQL;

        DB::unprepared($record_element_score);


        $question_averages = <<<MYSQL
DROP PROCEDURE IF EXISTS question_score_averages_for_exam;
CREATE PROCEDURE `question_score_averages_for_exam` (IN examId INT)
BEGIN
    SELECT qa.question_number AS questionNumber, q.questionName AS questionName, AVG(qs.score) AS average FROM question_scores qs
    INNER JOIN question_assignments qa ON qs.question_assignment_id = qa.id
    INNER JOIN questions q ON qa.question_id = q.id
    WHERE qa.exam_id = examId
    GROUP BY qs.question_assignment_id;
END;
MYSQL;

        DB::unprepared($question_averages);

//
//    $add_student = <<<MYSQL
//DROP PROCEDURE IF EXISTS add_or_update_student;
//CREATE PROCEDURE `add_or_update_student` (IN user_id INT
//MYSQL;













    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS assign_element');
        DB::unprepared('DROP PROCEDURE IF EXISTS assign_question');

        DB::unprepared('DROP PROCEDURE IF EXISTS record_question_score');
        DB::unprepared('DROP PROCEDURE IF EXISTS record_element_score');

    }
}

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
    CREATE PROCEDURE `assign_element` (IN examId INT, IN questionId INT, IN subtask INT, IN elementId INT)
    BEGIN
        INSERT INTO element_assignments (exam_id, question_id, subtask, element_id)
        VALUES (examId, questionId, subtask, elementId) ON DUPLICATE KEY UPDATE subtask = subtask;

        SELECT exam_id, question_id, element_id, subtask FROM element_assignments
        WHERE exam_id = examId
        AND question_id = questionId
        AND element_id = elementId
        AND subtask = subtask;
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


        $record_element_comment_text = <<<MYSQL
DROP PROCEDURE IF EXISTS record_element_comment_text;
CREATE PROCEDURE `record_element_comment_text`(IN elementAssignmentId INT, IN studentId INT, IN commentText TEXT)
  BEGIN
    INSERT INTO element_scores (element_assignment_id, student_id, comment_text)
    VALUES (elementAssignmentId, studentId, commentText)
    ON DUPLICATE KEY UPDATE comment_text = commentText;
  END;
MYSQL;
        DB::unprepared($record_element_comment_text);




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


        $record_or_update_grading_time = <<<MYSQL
DROP PROCEDURE IF EXISTS record_or_update_grading_time;
CREATE PROCEDURE `record_or_update_grading_time` (IN examId INT, IN studentId INT, IN toAdd FLOAT)
BEGIN
    INSERT INTO grading_times (exam_id, student_id, seconds) VALUES (examId, studentId, toAdd)
    ON DUPLICATE KEY UPDATE seconds = seconds + toAdd;
END;
MYSQL;
        DB::unprepared($record_or_update_grading_time);


        $record_grading_time = <<<MYSQL
DROP PROCEDURE IF EXISTS record_grading_time;
CREATE PROCEDURE `record_grading_time` (IN examId INT, IN studentId INT, IN gradingTime FLOAT)
BEGIN
    INSERT INTO grading_times (exam_id, student_id, seconds) VALUES (examId, studentId, gradingTime)
    ON DUPLICATE KEY UPDATE seconds = gradingTime;
END;
MYSQL;
        DB::unprepared($record_grading_time);


        $get_question_scores_for_student = <<<MYSQL
DROP PROCEDURE IF EXISTS get_question_scores_for_student;
CREATE PROCEDURE `get_question_scores_for_student` (IN userId INT, IN examId INT, IN studentId INT)
BEGIN
SELECT q.id AS questionId, qa.question_number AS questionNumber, q.questionName, qa.id AS questionAssignmentId,
                    (SELECT qs.score AS questionScore
                    FROM question_scores qs WHERE
                    qs.student_id = studentId
                    AND qs.question_assignment_id = questionAssignmentId) AS questionScore
                    FROM questions q
                    INNER JOIN question_assignments qa ON q.id = qa.question_id
                    WHERE qa.exam_id = examId
                    AND q.user_id = userId
                    ORDER BY qa.question_number ASC;
END;
MYSQL;
       // DB::unprepared($get_question_scores_for_student);


        $get_element_scores_for_student_by_question_id = <<<MYSQL
DROP PROCEDURE IF EXISTS get_element_scores_for_student_by_question_id;
CREATE PROCEDURE `get_element_scores_for_student_by_question_id` (IN userId INT, IN examId INT, IN questionId INT, IN studentId INT,
OUT elementId INT, OUT elementName TEXT, OUT questionNumber INT, OUT subtask INT, OUT elementAssignmentId INT, OUT elementScore FLOAT)
BEGIN
SELECT e.id AS elementId, e.elementName AS elementName, exq.subtask AS subtask, exq.id AS elementAssignmentId,
                (SELECT qa.question_number FROM question_assignments qa
                    WHERE qa.exam_id = examId
                        AND qa.question_id = questionId
                ) AS questionNumber,
                (SELECT score AS elementScore
                FROM element_scores WHERE element_assignment_id = elementAssignmentId
                AND student_id = studentId
                AND element_assignment_id = elementAssignmentId ) AS elementScore
                FROM elements e
                INNER JOIN element_assignments exq ON e.id = exq.element_id
                WHERE
                    e.user_id = userId
                    AND exq.exam_id = examId
                    AND exq.question_id = questionId
                    ORDER BY exq.subtask ASC;
END;
MYSQL;
//        DB::unprepared($get_element_scores_for_student_by_question_id);


$grading_stats = <<<MYSQL
DROP PROCEDURE IF EXISTS get_grading_stats;
CREATE PROCEDURE `get_grading_stats` (
    IN examId INT,
    OUT averageExamTime FLOAT,
    OUT totalExams INT,
    OUT totalGraded INT,
    OUT remainingExams INT,
    OUT gradeTimeRemaining FLOAT,
    OUT gradeTimeElapsed FLOAT
)
BEGIN
    SELECT @avgEx := ROUND(AVG(seconds), 2) INTO averageExamTime
        FROM grading_times
        WHERE exam_id = examId;

    SELECT @te := COUNT(ks.student_id) INTO totalExams
        FROM kumi_student ks
        INNER JOIN exam_kumi ek ON ks.kumi_id = ek.kumi_id
        WHERE ek.exam_id = examId;

    SELECT @tg := COUNT(exam_id) INTO totalGraded
        FROM grading_times
        WHERE exam_id = examId;

    SELECT ROUND(SUM(seconds), 2) INTO gradeTimeElapsed
        FROM grading_times
        WHERE exam_id = examId;

    SELECT @te - @tg INTO remainingExams;

    SELECT ROUND(averageExamTime * remainingExams, 2) INTO gradeTimeRemaining;

END;
MYSQL;
        DB::unprepared($grading_stats);



/**
 * DROP PROCEDURE IF EXISTS get_grading_stats;
CREATE PROCEDURE `get_grading_stats` (IN examId INT,
OUT averageExamTime FLOAT,
OUT totalGraded INT,
OUT remainingExams INT,
OUT gradeTimeRemaining FLOAT,
OUT gradeElapsed FLOAT,
OUT workElapsed FLOAT,
OUT workRemaining FLOAT)
BEGIN
SELECT ROUND(AVG(gt.seconds), 2) INTO AS avgExam,
(SELECT COUNT(ks.student_id) FROM kumi_student ks INNER JOIN exam_kumi ek ON ks.kumi_id = ek.kumi_id WHERE ek.exam_id = examId) AS total_exams,
(SELECT COUNT(gt.exam_id) INTO totalGraded WHERE gt.exam_id = examId),
(SELECT @remain := total_exams - @graded) AS remainingExams,
(SELECT ROUND(AVG(gt.seconds) * @remain, 2)) AS gradeTimeRemaining,
SUM(gt.seconds) AS gradeElapsed,
FROM grading_times gt
WHERE gt.examID = examId;
END;
 */


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

        DB::unprepared('DROP PROCEDURE IF EXISTS get_question_scores_for_student');
        DB::unprepared('DROP PROCEDURE IF EXISTS get_element_scores_for_student_by_question_id');

        DB::unprepared('DROP PROCEDURE IF EXISTS record_grading_time');

        DB::unprepared('DROP PROCEDURE IF EXISTS get_grading_stats');

    }
}

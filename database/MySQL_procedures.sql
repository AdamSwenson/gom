
DELIMITER $$
DROP PROCEDURE IF EXISTS assign_element $$
CREATE PROCEDURE `assign_element` (IN questionAssignmentId INT, IN subtask INT, IN elementId INT)
    BEGIN
        INSERT INTO element_assignments (question_assignment_id, subtask, element_id)
        VALUES (questionAssignmentId, subtask, elementId) ON DUPLICATE KEY UPDATE element_id = elementId;

        SELECT question_assignment_id, subtask, element_id FROM element_assignments
        WHERE question_assignment_id = questionAssignmentId AND subtask = subtask AND element_id = elementId;
    END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS assign_question $$
CREATE PROCEDURE `assign_question` (IN questionId INT, IN examId INT, IN questionNumber INT)
  BEGIN
    INSERT INTO question_assignments (question_id, exam_id, question_number)
    VALUES (questionId, examId, questionNumber)
    ON DUPLICATE KEY UPDATE question_id = questionId;
    END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS record_question_score $$
CREATE PROCEDURE `record_question_score`(IN questionAssignmentId INT, IN studentId INT, IN score FLOAT)
  BEGIN
  INSERT INTO question_scores (question_assignment_id, student_id, score)
  VALUES (questionAssignmentId, studentId, score)
  ON DUPLICATE KEY UPDATE score = score;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS record_element_score $$
CREATE PROCEDURE `record_element_score`(IN elementAssignmentId INT, IN studentId INT, IN score FLOAT)
  BEGIN
    INSERT INTO element_scores (element_assignment_id, student_id, score)
    VALUES (elementAssignmentId, studentId, score)
    ON DUPLICATE KEY UPDATE score = score;
  END $$
DELIMITER ;












# above this line things are good


DELIMITER $$
CREATE PROCEDURE `get_elements_for_question` (IN examId INT, IN questionId INT)
  BEGIN
  SELECT elementID, examID, questionID, subtask, elementAbbr, elementEnglish, locked
                FROM elementsXquestions
                NATURAL JOIN elements
                NATURAL JOIN questions
                NATURAL JOIN exams
                WHERE locked != 1
                AND examID = examId
                AND questionID = questionId
                ORDER BY subtask ASC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `get_questions_for_exam` (IN examId INT, IN questionId INT)
  BEGIN
    SELECT questionID, examID, questionNumber, questionName, questionTitle
                FROM questionAssigner INNER JOIN questions USING(questionID)
                WHERE examID = :examID
                ORDER BY questionNumber;
    END$$
DELIMITER ;

CREATE PROCEDURE `get_elements_for_exam` (IN examId INT, IN questionId INT)
BEGIN
SELECT e.elementID, exq.questionID, exq.subtask, e.elementAbbr, e.elementEnglish, q.questionNumber
            FROM elements e INNER JOIN elementsXquestions exq ON e.elementID = exq.elementID
            INNER JOIN questionAssigner q ON exq.questionID = q.questionID
            WHERE exq.examID = :examID AND q.examID = :examID;
END$$




CREATE PROCEDURE `remove_element_from_question`
  BEGIN
    DELETE FROM elementsXquestions WHERE examID = :examID AND questionID = :questionID AND elementID = :elementID;
    END$$


CREATE PROCEDURE `remove_question_from_exam`()
BEGIN
  DELETE FROM questionAssigner WHERE examID = :examID AND questionID = :itemID;
END$$



CREATE PROCEDURE `record_item_score`()
INSERT INTO " . $this->table . " (sid, examID, " . $this->id_field . " , " . $this->score_field . " )
				VALUES (:sid, :examID, :itemID, :score)
				ON DUPLICATE KEY UPDATE " . $this->score_field . " = :score;
END$$


CREATE PROCEDURE `get_element_scores_by_questionID`()
  BEGIN
    SELECT e.elementID, e.elementAbbr, exq.subtask, e.elementEnglish,
                (SELECT questionNumber FROM questionAssigner WHERE examID = :examID AND questionID = :questionID) AS questionNumber, e.elementID AS eid,
                (SELECT elementScore AS elementScore
                FROM elementScores WHERE examID = :examID
                AND sid = :sid
                AND elementID = eid ) AS elementScore
                FROM elements e
                INNER JOIN elementsXquestions exq ON e.elementID = exq.elementID
                WHERE exq.examID = :examID AND exq.questionID = :questionID"
                END$$

CREATE PROCEDURE `get_all_question_scores`(examId, studentId)
BEGIN
SELECT q.questionID, qa.questionNumber, q.questionTitle, q.questionID AS qid,
                    (SELECT questionScore AS questionScore
                    FROM questionScores WHERE examID = :examID
                    AND sid = :sid
                    AND questionID = qid
                    AND questionScore IS NOT NULL) AS questionScore
                    FROM questions q
                    INNER JOIN questionAssigner qa ON q.questionID = qa.questionID
                    WHERE qa.examID = :examID
                    ORDER BY qa.questionNumber ASC
  END$$


CREATE PROCEDURE `get_question_score`(questionId, examId, studentId)
 BEGIN
SELECT q.questionID AS questionID, q.questionName, qa.questionNumber, q.questionTitle, q.questionID AS qid,
                (SELECT questionScore AS questionScore
                FROM questionScores WHERE examID = :examID
                AND sid = :sid
                AND questionID = qid ) AS questionScore
                FROM questions q
                INNER JOIN questionAssigner qa ON q.questionID = qa.questionID
                WHERE qa.examID = :examID AND qa.questionNumber = :questionNumber
  END$$
CREATE PROCEDURE `all_question_scores`(examId, studentId)
  BEGIN
SELECT q.questionID, qa.questionNumber, q.questionTitle, q.questionID AS qid,
                    (SELECT questionScore AS questionScore
                    FROM questionScores WHERE examID = :examID
                    AND sid = :sid
                    AND questionID = qid
                    AND questionScore IS NOT NULL) AS questionScore
                    FROM questions q
                    INNER JOIN questionAssigner qa ON q.questionID = qa.questionID
                    WHERE qa.examID = :examID
                    ORDER BY qa.questionNumber ASC
  END$$

CREATE PROCEDURE `particular_question_score`(examId, studentId, questionId)
BEGIN
SELECT q.questionID AS questionID, q.questionName, qa.questionNumber, q.questionTitle, q.questionID AS qid,
                (SELECT questionScore AS questionScore
                FROM questionScores WHERE examID = :examID
                AND sid = :sid
                AND questionID = qid ) AS questionScore
                FROM questions q
                INNER JOIN questionAssigner qa ON q.questionID = qa.questionID
                WHERE qa.examID = :examID AND qa.questionNumber = :questionNumber;
END$$


CREATE PROCEDURE `all_element_scores`(examId, studentId)
BEGIN
SELECT qa.questionID, qa.questionNumber FROM questionAssigner qa WHERE examID = :eid;

SELECT e.elementID, e.elementAbbr, exq.subtask, e.elementEnglish,
                    (SELECT questionNumber FROM questionAssigner WHERE examID = :examID AND questionID = :questionID) AS questionNumber, e.elementID AS eid,
                    (SELECT elementScore AS elementScore
                    FROM elementScores WHERE examID = :examID
                    AND sid = :sid
                    AND elementID = eid ) AS elementScore
                    FROM elements e
                    INNER JOIN elementsXquestions exq ON e.elementID = exq.elementID
                    WHERE exq.examID = :examID AND exq.questionID = :questionID
END$$


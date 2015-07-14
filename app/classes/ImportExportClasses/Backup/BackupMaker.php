<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\ImportExportClasses\Backup;

use App\classes\QuestionClasses\service\QuestionsForExamGenerator;
use App\classes\ScoreClasses\ScoreLoader;
use App\classes\StudentClasses\StudentsForExamGenerator;

/**
 * This creates downloadable csv files from queries to allow users to backup their data
 * @todo Make subclasses for backing up other data (grading info etc)
 *
 * @author adam
 */
class BackupMaker
{

    /** @var  $exam \Exam */
    public $exam;

    /** @var  ScoreLoader */
    public $scoreLoader;

    public $records = array();

    /**
     * @param \Exam $exam
     */
    public function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * @param ScoreLoader $scoreLoader
     */
    public function setScoreLoader(ScoreLoader $scoreLoader)
    {
        $this->scoreLoader = $scoreLoader;
    }


    /**
     * Creates the records for the backup
     */
    public function loadRecords()
    {
        $studentGenerator = new StudentsForExamGenerator();
        foreach ($studentGenerator($this->exam) as $student) {
            $record = array('studentName' => $student->getStudentname(), 'student id' => $student->getSid());
            $questionGenerator = new QuestionsForExamGenerator($this->exam);
            foreach ($questionGenerator($this->exam) as $question) {
                $scores = $this->scoreLoader->loadForBackup($this->exam, $question, $student);
                foreach($scores as $key => $val){
                    $record[$key] = $val;
                }
            }
            array_push($this->records, $record);
        }
    }


    /**
     * This downloads a csv file with each students' scores on elements and questions for the exam
     */
    public function backup_score_data()
    {
        try {
            $this->loadRecords();
            if (count($this->records) > 0)
            {
                $date = date('Y-m-d_H-i-s');
                ob_start();
                $filename = "Student_scores_exam_" . $this->exam->getId() . "_" . $date . ".csv";
                $output = fopen('php://output', 'w') or die("Can't open php://output");
                // Tell browser to expect a CSV file
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                // Add header row
                $column_headers = array();
                foreach ($this->records[0] as $k => $v) {
                    array_push($column_headers, $k);
                }
                fputcsv($output, $column_headers);
                // Add each data row
                foreach ($this->records as $record) {
                    $line = array();
                    foreach ($record as $k => $v) {
                        array_push($line, $v);
                    }
                    fputcsv($output, $line);
                }
                fclose($output) or die("Can't close php://output");
                ob_end_flush();
            }
        } catch (\Exception $e) {
            error_log($e);
        }
    }

//
//        }($this->students as $student)
//        {
//            $question = '';
//            $scores = $score_loader->load($this->exam, $question, $student);
//
//}

//    public function load()
//    {
//        $this->load_students();
//        if (count($this->students) > 0) {
//            $this->load_questions();
//            $score_loader = new \App\classes\ScoreClasses\ScoreLoader();
//            $score_loader->set_element_score_handler(new \App\classes\ScoreClasses\ElementScoreHandler());
//            $score_loader->set_question_score_handler(new \App\classes\ScoreClasses\QuestionScoreHandler());
//            foreach ($this->students as $student) {
//                $question = '';
//                $scores = $score_loader->load($this->exam, $question, $student);
//            }
//
//
//        }
//
//
////        \StudentQuery::create()
//        $cleaner = new \App\classes\SecurityClasses\cleaning\CleanerFactory();
//        $question_factory = new \App\classes\QuestionClasses\service\QuestionFactory();
//        $question_factory->set_cleaner($cleaner);
//        $question_factory->set_question_assignment_dao(new \App\classes\QuestionClasses\dao\QuestionAssignmentDAO());
//
//        $student_factory = new \App\classes\StudentClasses\StudentFactory();
//        $student_factory->set_cleaner($cleaner);
//
//        $element_factory = new \App\classes\ElementClasses\service\ElementFactory();
//        $element_factory->set_cleaner($cleaner);
//
//        $question_factory->set_exam($this->exam);
//
//        $question = $question_factory->load_blind($request);
//        $student = $student_factory->load_from_request($request);
//        if (isset($this->exam) && isset($question) && isset($student)) {
//            $score_loader = new \App\classes\ScoreClasses\ScoreLoader();
//            $score_loader->set_element_score_handler(new \App\classes\ScoreClasses\ElementScoreHandler());
//            $score_loader->set_question_score_handler(new \App\classes\ScoreClasses\QuestionScoreHandler());
//            $scores = $score_loader->load($exam, $question, $student);
//
//        }
//    }

//    public function load_elements()
//    {
//        $this->query = "SELECT elementAbbr FROM elements e INNER JOIN elementsXquestions exq ON e.elementID = exq.elementID WHERE exq.examID = :examID";
//        $this->vals = array('examID' => $this->examID);
//        $this->returnAssocAll();
//        $this->elements = array();
//        foreach ($this->resultAssoc as $row) {
//            array_push($this->elements, $row['elementAbbr']);
//        }
//    }
//
//    public function load_questions()
//    {
//        $this->query = "SELECT q.questionName FROM questions q INNER JOIN questionAssigner qa ON q.questionID = qa.questionID WHERE qa.examID = :examID";
//        $this->vals = array('examID' => $this->examID);
//        $this->returnAssocAll();
//        $this->questions = array();
//        foreach ($this->resultAssoc as $row) {
//            array_push($this->questions, $row['questionName']);
//        }
//
//    }
//
//    public function load_studentids()
//    {
//        $this->query = "SELECT s.sid
//            FROM students s INNER JOIN studentsXclasses sxc ON s.sid = sxc.sid
//            INNER JOIN classesXexams cxe ON sxc.classID = cxe.classID
//            WHERE cxe.examID = :examID";
//        $this->vals = array('examID' => $this->examID);
//        $this->returnAssocAll();
//        $this->studentids = array();
//        foreach ($this->resultAssoc as $row) {
//            array_push($this->studentids, $row['sid']);
//        }
//    }
//
//    /**
//     * Builds the query to get all data for a student on the exam
//     * @param type $sid
//     * @return string The SQL query string
//     */
//    protected function build_query($sid)
//    {
//        $stem = "SELECT (SELECT studentName FROM students WHERE sid = $sid) AS studentName, (SELECT sid FROM students WHERE sid = $sid) AS sid, ";
//        foreach ($this->elements as $element) {
//            $stem = $stem . "(SELECT es.elementScore "
//                . "FROM elementScores es INNER JOIN elements e ON es.elementID = e.elementID "
//                . "WHERE es.sid = $sid AND examID = $this->examID AND e.elementAbbr = '$element') AS $element , ";
//        }
//        $limit = count($this->questions) - 1;
//        $i = 0;
//        foreach ($this->questions as $question) {
//            $stem = $stem . "(SELECT qs.questionScore "
//                . "FROM questionScores qs INNER JOIN questions q ON qs.questionID = q.questionID "
//                . "WHERE qs.sid = $sid AND examID = $this->examID AND q.questionName = '$question') AS $question";
//            if ($i < $limit) {
//                $stem = $stem . ', ';
//            }
//            $i += 1;
//        }
//
//        return $stem;
//    }
//
//    /**
//     * After studentids have been loaded, this iterates through them and gets the records for each student, storing them in this->records
//     */
//    protected function get_records()
//    {
//        $this->records = array();
//        foreach ($this->studentids as $sid) {
//            $this->query = $this->build_query($sid);
//            $this->returnAssocFirst();
//            array_push($this->records, $this->resultAssoc);
//        }
//    }


}

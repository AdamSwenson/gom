<?php

namespace App\Jobs\Export;

use App\Exam;
use App\Feedback;
use App\Jobs\Job;
use App\Repositories\Student\StudentsForExamGenerator;
use App\Student;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;

/**
 * Given an exam, this handles exporting all question and element scores for the exam
 *
 * @package App\Jobs\Export
 */
class ExportScores extends Job implements SelfHandling
{

    /** @var  $exam Exam */
    public $exam;

    public $records = [];

    /** @var StudentsForExamGenerator */
    public $studentsGenerator;

    /** @var \App\Repositories\Question\QuestionsForExamGenerator */
    public $questionsGenerator;

    /** @var \App\Repositories\Score\IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var \App\Repositories\Score\IElementScoreRepository */
    protected $elementScoreDao;

    /** @var \App\Repositories\Feedback\IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var \App\Repositories\Grade\IStudentGradeRepository  */
    protected $studentGradeRepository;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //        $this->questionsGenerator = app()->make('QuestionsForExamGenerator');
        $this->questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
        $this->accessKeyRepository = app()->make('App\Repositories\Feedback\IAccessKeyRepository');
        $this->studentGradeRepository = app()->make('App\Repositories\Grade\IStudentGradeRepository');
    }

    /**
     * Execute the job.
     * @param Exam $exam
     * @return void
     */
    public function handle(Exam $exam)
    {
        $this->exam = $exam;
        $this->loadRecords();
        $this->backup_score_data();
    }


    /**
     * Creates the records for the backup
     */
    public function loadRecords()
    {
        //Dunno why loading this from the service provider makes phpstorm mark as error; still works
        $studentsGenerator = new StudentsForExamGenerator();
//        $studentsGenerator = app()->make('StudentsForExamGenerator');

        foreach ($studentsGenerator($this->exam) as $student)
        {
            $record = [
                'Student name' => $student->getFullName(),
                'Id' => $student->getStudentId()
            ];

            //Load the question scores and add to the array
            $questionScores = $this->questionScoreDao->load_for_student_on_exam($this->exam->getId(), $student->getId());

            foreach ($questionScores as $qs)
            {
                $questionName = 'Q' . $qs->questionNumber . ' ' . $qs->questionName;
                $record[$questionName] = $qs->questionScore;

                $elementScores = $this->elementScoreDao->load_all_for_student_by_question_id($this->exam->getId(), $qs->questionId, $student->getId());
                foreach ($elementScores as $es)
                {
                    $elementName = 'Q' . $qs->questionNumber . 'E' . $es->subtask . ' ' . $es->elementName;
                    $record[$elementName] = $es->elementScore;
                }
            }

            //Add the total score
            $record['totalQuestionScore'] = $this->loadTotalScore($student);

            //If a grade has been assigned, we'll download that too
            //If not, the value will be null
            $record['letterGrade'] = $this->loadStudentGrade($student);

            //Add it to the records array
            array_push($this->records, $record);
        }
    }


    /**
     * This downloads a csv file with each students' scores on elements and questions for the exam
     */
    public function backup_score_data()
    {
        try
        {
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
                foreach ($this->records[0] as $k => $v)
                {
                    array_push($column_headers, $k);
                }
                fputcsv($output, $column_headers);
                // Add each data row
                foreach ($this->records as $record)
                {
                    $line = array();
                    foreach ($record as $k => $v)
                    {
                        array_push($line, $v);
                    }
                    fputcsv($output, $line);
                }
                fclose($output) or die("Can't close php://output");
                ob_end_flush();
            }
        } catch (\Exception $e)
        {
            Log::error($e);
        }
    }


    /**
     * Checks whether a grade has been recorded in the feedback for the
     * student. If so, it returns the letter grade. If not, it returns null.
     * @param Student $student
     * @return null|string
     */
    protected function loadStudentGrade(Student $student)
    {
        //First, check if feedback has been created for the student.
        $accessKey = $this->accessKeyRepository->getAccessKeyForStudent($this->exam->getId(), $student->getId());

        if( !empty($accessKey) )
        {
            $feedback = Feedback::where('access_key', $accessKey)->first();
            return $feedback->grade();
        }

        return null;
    }

    /**
     * Calculate the student's total score and return it or null
     * @param Student $student
     * @return null
     */
    protected function loadTotalScore(Student $student)
    {
        $totalScore = $this->studentGradeRepository->calculateTotalScoreForStudent($this->exam, $student);
        if( !empty($totalScore) )
        {
            return $totalScore;
        }
        return null;
    }
}

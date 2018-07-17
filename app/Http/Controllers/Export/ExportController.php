<?php

namespace App\Http\Controllers\Export;

use App\Assignment;
use App\Exam;
use App\Item;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Models\NewGom\ItemScore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Jobs\Export\ExportScores;

use App\Feedback;
use App\Jobs\Job;
use App\Repositories\Student\StudentsForExamGenerator;
use App\Student;


/**
 * This handles exporting student scores for versions
 * 0.2.0 and up.
 *
 * @package App\Http\Controllers
 */
class ExportController extends Controller
{
    protected static $numRuns = 0;
    protected static $lastRun = null;


    /** @var  $exam Exam */
    public $exam;

    public $records = [];

    /** @var StudentsForExamGenerator */
    public $studentsGenerator;

    /** @var \App\Repositories\Question\QuestionsForExamGenerator */
    public $questionsGenerator;
    public $items = [];
    public $headers;

    /** @var \App\Repositories\Score\IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var \App\Repositories\Score\IElementScoreRepository */
    protected $elementScoreDao;

    /** @var \App\Repositories\Feedback\IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var \App\Repositories\Grade\IStudentGradeRepository */
    protected $studentGradeRepository;

    protected $outputFilename;
    protected $outputPath;


    public function __construct()
    {
        $this->middleware('auth');

        $this->items = [];
        $this->records = [];

        //make headers
        $this->headers = ['Name', 'Id'];


    }

    protected function initializeFilepath()
    {

        $date = date('Y-m-d_H-i-s');
        $eid = $this->exam->getId();

        $this->outputFilename = "Student_scores_exam_{$eid}_{$date}.csv";

        $this->outputPath = storage_path() . "/temp/" . $this->outputFilename;

    }

    /**
     * Populates the items and headers from the assignment tree.
     */
    public function loadItems()
    {
        $assignments = Assignment::where('exam_id', $this->exam->id)->get();
        foreach ( $assignments as $assignment ) {

            $item = Item::where('id', $assignment->item_id)->first();
            //The assignment's root node will be the exam, so the item_id will
            //be null. Thus there will not be a result
            if ( !is_null($item) ) {
                array_push($this->items, $item);
                array_push($this->headers, $item->name);
            }
        }

    }

    /**
     * Populates the records array
     */
    public function loadScores()
    {

        //get all scores for all items and all students
        $scores = ItemScore::where('exam_id', $this->exam->id)->get()->groupby('student_id');
//dd($scores);
        foreach ( $scores as $studentId => $scoreList ) {
            $record = [];
            $student = Student::where('id', $studentId)->first();
//            dd($studentId, $scoreList);
            array_push($record, "$student->last_name, $student->first_name");
            array_push($record, $student->student_identifier);

//            dd($this->items);
            foreach ( $this->items as $item ) {
                $score = $scoreList->where('item_id', $item->id)->first();
                if ( !is_null($score) ) {
                    array_push($record, $score->score);
                } else {
                    array_push($record, '');
                }

            }

            //add total score

            //add grade

            //add to the record list
            array_push($this->records, $record);
        }

    }


    public function exportExamScores( Exam $exam )
    {
        $user = Auth::user();
        if ( $user->owns($exam) ) {

            $this->exam = $exam;
                            $this->initializeFilepath();


            $this->loadItems();

            //finish making headers
            array_push($this->headers, 'Total Score');
            array_push($this->headers, 'Grade');
            array_push($this->records, $this->headers);

            $this->loadScores();

            $this->write_csv_file();

            $headers = ['Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$this->outputFilename"
            ];

            return response()
                ->download($this->outputPath, $this->outputFilename, $headers)->deleteFileAfterSend(true);

        }
    }

    /**
     * This creates a csv file in the temp storage folder
     * which contains with each students' scores for each
     * item on the exam
     */
    public function write_csv_file()
    {
//        try {
                $file = fopen($this->outputPath, 'w');
//                $output = fopen('php://output', 'w') or die("Can't open php://output");

                // Add header row
                fputcsv($file, $this->headers);

                // Add each data row
                foreach ( $this->records as $line ) {
                    fputcsv($file, $line);
                }

                fclose($file); // or die("Can't close php://output");

            // }
        // } catch (\Exception $e) {
        //     Log::error($e);
        // }
    }


    /**
     * Checks whether a grade has been recorded in the feedback for the
     * student. If so, it returns the letter grade. If not, it returns null.
     * @param Student $student
     * @return null|string
     */
    protected function loadStudentGrade( Student $student )
    {
        //First, check if feedback has been created for the student.
        $accessKey = $this->accessKeyRepository->getAccessKeyForStudent($this->exam->getId(), $student->getId());

        if ( !empty($accessKey) ) {
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
    protected function loadTotalScore( Student $student )
    {
        $totalScore = $this->studentGradeRepository->calculateTotalScoreForStudent($this->exam, $student);
        if ( !empty($totalScore) ) {
            return $totalScore;
        }
        return null;
    }

}

//
//    /**
//     * Create a new job instance.
//     */
//    public function __construct( )
//    {
//        //        $this->questionsGenerator = app()->make('QuestionsForExamGenerator');
//        $this->questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
//        $this->elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
//        $this->accessKeyRepository = app()->make('App\Repositories\Feedback\IAccessKeyRepository');
//        $this->studentGradeRepository = app()->make('App\Repositories\Grade\IStudentGradeRepository');
//    }
//
//    /**
//     * Creates the records for the backup
//     */
//    public function loadRecords()
//    {
//        //Dunno why loading this from the service provider makes phpstorm mark as error; still works
//        $studentsGenerator = new StudentsForExamGenerator();
////        $studentsGenerator = app()->make('StudentsForExamGenerator');
//
//        foreach ( $studentsGenerator($this->exam) as $student ) {
//            $record = [
//                'Student name' => $student->getFullName(),
//                'Id' => $student->getStudentId()
//            ];
//
//            //Load the question scores and add to the array
//            $questionScores = $this->questionScoreDao->load_for_student_on_exam($this->exam->getId(), $student->getId());
//
//            foreach ( $questionScores as $qs ) {
//                $questionName = 'Q' . $qs->questionNumber . ' ' . $qs->questionName;
//                $record[$questionName] = $qs->questionScore;
//
//                $elementScores = $this->elementScoreDao->load_all_for_student_by_question_id($this->exam->getId(), $qs->questionId, $student->getId());
//                foreach ( $elementScores as $es ) {
//                    $elementName = 'Q' . $qs->questionNumber . 'E' . $es->subtask . ' ' . $es->elementName;
//                    $record[$elementName] = $es->elementScore;
//                }
//            }
//
//            //Add the total score
//            $record['totalQuestionScore'] = $this->loadTotalScore($student);
//
//            //If a grade has been assigned, we'll download that too
//            //If not, the value will be null
//            $record['letterGrade'] = $this->loadStudentGrade($student);
//
//            //Add it to the records array
//            array_push($this->records, $record);
//        }
//    }
//

<?php

namespace App\Http\Controllers\Export;

use App\Assignment;
use App\Exam;
use App\Item;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Models\NewGom\ItemScore;
use App\Repositories\Grade\StudentGradeRepositoryNew;
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

    /** @var \App\Repositories\Feedback\IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var \App\Repositories\Grade\IStudentGradeRepository */
    protected $studentGradeRepository;

    protected $outputFilename;
    protected $outputPath;


    public function __construct()
    {
        $this->middleware('auth');

        $this->studentGradeRepository = new StudentGradeRepositoryNew();


        //start making headers list
        //The item names will be added later during loadItems
        //and the score and grade will be added after that.
        $this->headers = ['Name', 'Id'];
    }



    /**
     * THIS IS THE MAIN PUBLICLY CALLABLE METHOD 
     * 
     * This returns a csv file containing all the recorded scores for the 
     * exam. 
     * 
     * If a student has not had their exam graded, they will not be
     * included in the file.
     * 
     */
    public function exportExamScores( Exam $exam )
    {
        $user = Auth::user();
        if ( $user->owns($exam) ) {
            $this->exam = $exam;

            $this->initializeFilepath();

            $this->loadItems();

            $this->loadScores();

            $this->write_csv_file();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=" . $this->outputFilename,
                'filename' => $this->outputFilename
            ];

            return response()
                ->download($this->outputPath, $this->outputFilename, $headers)
                ->deleteFileAfterSend(true);

        }
    }

    /**
     * HELPER FUNCTION. SHOULD NOT BE CALLED FROM OUTSIDE.
     * (Keeping public for ease of testing)
     *
     * Sets the temporary file which will be created and then
     * deleted after sending.
     */
    protected function initializeFilepath()
    {
        $date = date('Y-m-d_H-i-s');
        $eid = $this->exam->getId();
        $this->outputFilename = "Student-scores_{$date}.csv";
        $this->outputPath = storage_path() . "/temp/" . $this->outputFilename;

    }


    /**
     * HELPER FUNCTION. SHOULD NOT BE CALLED FROM OUTSIDE.
     * (Keeping public for ease of testing)
     *
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

        //finish making headers
        array_push($this->headers, 'Total Score');
        array_push($this->headers, 'Grade (letter)');
        array_push($this->headers, 'Grade (numeric)');
    }

    /**
     * HELPER FUNCTION. SHOULD NOT BE CALLED FROM OUTSIDE.
     * (Keeping public for ease of testing)
     *
     * Populates the records array
     * NB, if any students do not yet have grades, they will not be included in the download
     */
    public function loadScores()
    {
        //get all scores for all items and all students
        $scores = ItemScore::where('exam_id', $this->exam->id)
            ->get()
            ->groupby('student_id');

        foreach ( $scores as $studentId => $scoreList ) {
            $record = [];
            $student = Student::where('id', $studentId)->first();

            array_push($record, "$student->last_name, $student->first_name");
            array_push($record, $student->student_identifier);


            foreach ( $this->items as $item ) {
                $score = $scoreList->where('item_id', $item->id)->first();
                if ( !is_null($score) ) {
                    array_push($record, $score->score);
                } else {
                    array_push($record, '');
                }
            }

            //add total score
            array_push($record, $this->loadTotalScore($student));

            //add grade
            $gradeAssignment = $this->studentGradeRepository->getStudentGrade($this->exam, $student);
            if ( !is_null($gradeAssignment) ) {
                array_push($record, $gradeAssignment->getDisplayValue());
                array_push($record, $gradeAssignment->getCalcValue());
            }
            //add to the record list
            array_push($this->records, $record);
        }

    }


    /**
     * HELPER FUNCTION. SHOULD NOT BE CALLED FROM OUTSIDE.
     * (Keeping public for ease of testing)
     *
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


    /**
     * POSSIBLE ALTERNATIVE. NOT WORKING.
     *
     * Based on https://blog.pitchero.com/tech/send-a-csv-response-in-laravel
     * @return StreamedResponse
     */
    public function stream_csv_response()
    {

        $csv_data = array_push($this->headers, $this->records);

        return new StreamedResponse(
            function () use ( $csv_data ) {
                // A resource pointer to the output stream for writing the CSV to
                $handle = fopen('php://output', 'w');

                foreach ( $csv_data as $row ) {
                    // Loop through the data and write each entry as a new row in the csv
                    fputcsv($handle, $row);
                }

                fclose($handle);
            },
            200,
            [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=members.csv'
            ]
        );

    }

    /**
     * HELPER FUNCTION. SHOULD NOT BE CALLED FROM OUTSIDE.
     * (Keeping public for ease of testing)
     *
     * This creates a csv file in the temp storage folder
     * which contains with each students' scores for each
     * item on the exam.
     *
     * Note we might consider streaming the response instead
     */
    public function write_csv_file()
    {
        $file = fopen($this->outputPath, 'w');

        // Add header row
        fputcsv($file, $this->headers);

        // Add each data row
        foreach ( $this->records as $line ) {
            fputcsv($file, $line);
        }

        fclose($file);
    }


}

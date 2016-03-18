<?php

namespace App\Jobs\AsyncStorage;

use App\Exam;
use App\Jobs\Job;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Updates the count of how many students have been graded in redis
 * @package App\Jobs\AsyncStorage
 */
class UpdateStoredNumGraded extends Job implements SelfHandling
{
    /** @var INumberGradedStatsRepository */
    protected $numberGradedRepository;
    /**
     * @var IQuestionAssignmentRepository
     */
    private $questionAssignmentRepository;
    /**
     * @var IStudentRepository
     */
    private $studentRepository;
    /**
     * @var Exam
     */
    private $exam;


    /**
     * Create a new job instance.
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
        $this->numberGradedRepository = app()->make('App\Repositories\Exam\INumberGradedRepository');
        $this->questionAssignmentRepository = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->studentRepository = app()->make('App\Repositories\Student\IStudentRepository');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateGradedStudents();
    }

    public function updateGradedStudents()
    {
        $query = <<<MYSQL
        SELECT count( DISTINCT student_id) AS numberGraded
        FROM question_scores qs
        INNER JOIN question_assignments qa ON qs.question_assignment_id = qa.id
        WHERE qa.exam_id = :examId;
MYSQL;
        //get counts
        $result = DB::select($query, ['examId' => $this->exam->id]);
        $numberGraded = $result[0]->numberGraded;
Log::info($numberGraded);

        $storedNumber = $this->numberGradedRepository->getNumberGraded($this->exam);

        if ( $numberGraded !== $storedNumber )
        {
            //reset the count to 0 and add the correct number
            $this->numberGradedRepository->addGradedStudents($this->exam, $numberGraded, true);
        }

    }
}

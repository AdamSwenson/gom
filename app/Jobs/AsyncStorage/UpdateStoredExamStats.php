<?php

namespace App\Jobs\AsyncStorage;

use App\Exam;
use App\Jobs\Job;
use App\Repositories\Exam\IStoredExamStatsRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Used to asynchronously make sure the number of questions and number of students are updated in Redis.
 * @package App\Jobs
 */
class UpdateStoredExamStats extends Job implements SelfHandling
{
    /** @var IStoredExamStatsRepository */
    protected $storedExamStatsRepository;
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
        $this->storedExamStatsRepository = app()->make('App\Repositories\Exam\IStoredExamStatsRepository');
        $this->questionAssignmentRepository = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->studentRepository = app()->make('App\Repositories\Student\IStudentRepository');
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateQuestions();
        $this->updateStudents();
    }

    public function updateStudents(){
        $numberStudents = sizeof($this->studentRepository->load_students_by_exam($this->exam->getId()));
        $storedNumber = $this->storedExamStatsRepository->getNumberStudents($this->exam);

        if($numberStudents !== $storedNumber){
            //reset the count to 0 and add the correct number
            $this->storedExamStatsRepository->addStudents($this->exam, $numberStudents, true);
        }
    }

    public function updateQuestions(){
        $numberQuestions = sizeof($this->questionAssignmentRepository->load_all_for_exam($this->exam->getId()));
        $storedNumber = $this->storedExamStatsRepository->getNumberQuestions($this->exam);

        if($numberQuestions !== $storedNumber){
            //reset the count to 0 and add the correct number
            $this->storedExamStatsRepository->addQuestions($this->exam, $numberQuestions, true);
        }
    }
}

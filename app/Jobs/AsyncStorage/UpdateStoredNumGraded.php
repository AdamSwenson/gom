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

    /** @var Exam */
    protected $exam;

    /**
     * Create a new job instance.
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
        $this->numberGradedRepository = app()->make('App\Repositories\Exam\INumberGradedRepository');
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

    /**
     * Looks up the stored number of graded students and compares
     * that to the number of students with at least one question score
     * recorded. If different, updates the stored number to the calculated
     * number
     */
    public function updateGradedStudents()
    {
        $numberGraded = $this->numberGradedRepository->calculateNumberGradedFromMySQL($this->exam);

        $storedNumber = $this->numberGradedRepository->getNumberGraded($this->exam);

        if ( $numberGraded !== $storedNumber )
        {
            //reset the count to 0 and add the correct number
            $this->numberGradedRepository->addGradedStudents($this->exam, $numberGraded, true);
        }
    }
}

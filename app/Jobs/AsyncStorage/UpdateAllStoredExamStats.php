<?php

namespace App\Jobs\AsyncStorage;

use App\Exam;
use App\Jobs\Job;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Updates all stored question and student counts in redis
 * for all exams belonging to the user.
 * This isn't commonly used. Mainly only used to update things
 * once the storedExamStatsRepository features are added
 * @package App\Jobs\AsyncStorage
 */
class UpdateAllStoredExamStats extends Job
{
    use DispatchesJobs;

    protected $exams;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->exams = Exam::loggedIn()->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->exams as $exam){
            $this->dispatch(new UpdateStoredExamStats($exam));
        }

    }
}

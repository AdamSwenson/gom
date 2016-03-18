<?php

namespace App\Jobs\AsyncStorage;

use App\Exam;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UpdateAllStoredNumGraded extends Job implements SelfHandling
{
    use DispatchesJobs;
    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exams = Exam::loggedIn()->get();
        foreach($exams as $exam){
            $this->dispatch(new UpdateStoredNumGraded($exam));
        }
    }
}

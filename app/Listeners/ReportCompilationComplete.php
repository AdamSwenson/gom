<?php

namespace App\Listeners;

use App\Events\FeedbackCompilationCompleteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ReportCompilationComplete
 * Actions to do when the feedback compilation is complete
 * @package App\Listeners
 */
class ReportCompilationComplete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FeedbackCompilationCompleteEvent  $event
     */
    public function handle(FeedbackCompilationCompleteEvent $event)
    {

     //   return view('feedback.progress_sending');

    }
}

<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExamReleasedEvent' =>
            [
                'App\Listeners\FeedbackCompileListener'
            ],
        'App\Events\FeedbackCompilationCompleteEvent' =>
            [
                'App\Listeners\ReportCompilationComplete',
                'App\Listeners\NotifyStudentsListener'
            ],
        'App\Listeners\NewUserSignedUpEvent' =>
            [
                'App\Listeners\SendWelcomeEmailListener'
            ],
        'App\Events\StudentNotificationCompleteEvent' =>
            [
                'App\Listeners\ReportNotificationComplete'
            ],
        'App\Events\UnreleaseExamEvent' =>
            [
                'App\Listeners\RemoveStudentAccessListener'
            ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}

<?php

namespace App\Providers;

use App\Events\UserLoginEvent;
use App\Listeners\FlagForDatabaseBackupListener;
use App\Listeners\UserLoginListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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

        'App\Events\NewUserSignedUpEvent' =>
            [
                'App\Listeners\NewUserListener'
            ],

        'App\Events\StudentNotificationCompleteEvent' =>
            [
                'App\Listeners\ReportNotificationComplete'
            ],

        'App\Events\UnreleaseExamEvent' =>
            [
                'App\Listeners\RemoveStudentAccessListener'
            ],

        UserLoginEvent::class =>
            [
                UserLoginListener::class,
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

        // Fired on successful logins...
        $events->listen('auth.login', function ($user, $remember) {
            Event::fire(new UserLoginEvent());
        });


        //
    }
}

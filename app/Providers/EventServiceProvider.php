<?php

namespace App\Providers;

use App\Events\Ajax\PleaseSendAjaxFail;
use App\Events\Ajax\PleaseSendAjaxSuccess;
use App\Events\AsyncJobCompleteEvent;
use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\NewUserSignedUpEvent;
use App\Events\PleaseRecordGradingTime;
use App\Events\StudentNotificationCompleteEvent;
use App\Events\UnreleaseExamEvent;
use App\Events\UserLoginEvent;
use App\Jobs\RecordGradingTime;
use App\Listeners\Ajax\PleaseSendAjaxFailListener;
use App\Listeners\Ajax\PleaseSendAjaxSuccessListener;
use App\Listeners\AsyncJobCompleteListener;
use App\Listeners\FeedbackCompileListener;
use App\Listeners\FlagForDatabaseBackupListener;
use App\Listeners\NewUserListener;
use App\Listeners\NotifyStudentsListener;
use App\Listeners\RemoveStudentAccessListener;
use App\Listeners\ReportCompilationComplete;
use App\Listeners\ReportNotificationComplete;
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
        //authentication and authorization events
        Illuminate\Auth\Events\Registered::class => [
        ],

        Illuminate\Auth\Events\Attempting::class => [
        ],

        Illuminate\Auth\Events\Authenticated::class => [
        ],

        Illuminate\Auth\Events\Login::class => [
            UserLoginListener::class
         ],

        Illuminate\Auth\Events\Logout::class => [
         ],

        Illuminate\Auth\Events\Lockout::class => [
        ],

        //this event seems not to fire
        UserLoginEvent::class          => [
            UserLoginListener::class,
        ],


        AsyncJobCompleteEvent::class => [
            AsyncJobCompleteListener::class,
        ],

        ExamReleasedEvent::class => [
            FeedbackCompileListener::class,
        ],

        FeedbackCompilationCompleteEvent::class => [
            ReportCompilationComplete::class,
            NotifyStudentsListener::class,
        ],

        NewUserSignedUpEvent::class => [
            NewUserListener::class,
        ],

        StudentNotificationCompleteEvent::class => [
            ReportNotificationComplete::class,
        ],

        UnreleaseExamEvent::class => [
            RemoveStudentAccessListener::class,
        ],



        //Grade
        PleaseRecordGradingTime::class => [
            GradingRecordListener::class,
        ],

        //Ajax responses
        PleaseSendAjaxFail::class      => [PleaseSendAjaxFailListener::class],
        PleaseSendAjaxSuccess::class   => [PleaseSendAjaxSuccessListener::class],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Fired on successful logins...
        Event::listen('auth.login', function ($user, $remember)
        {
            Event::fire(new UserLoginEvent());
        });
    }
//
//    /**
//     * Register any other events for your application.
//     *
//     * @param  \Illuminate\Contracts\Events\Dispatcher $events
//     * @return void
//     */
//    public function boot(DispatcherContract $events)
//    {
//        parent::boot($events);
//
//        // Fired on successful logins...
//        $events->listen('auth.login', function ($user, $remember) {
//            Event::fire(new UserLoginEvent());
//        });
//

    //

}

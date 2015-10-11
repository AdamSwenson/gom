<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //  Exam::class => ExamPolicy::class
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        /*
       * Since there are not yet roles (e.g., teacher, TA) we don't yet need
       * any special policies that treat access, alteration, and deletion differently
       * or differently for different objects.
       * Thus these are just generic checks which can be used on any of the non-junction
       * based objects (i.e., exams, questions, elements, students, etc
       */
        $gate->define('access-object', function($user, $object){
            return $user->owns($object);
        });

        $gate->define('alter-object', function($user, $object){
            return $user->owns($object);
        });

        $gate->define('destroy-object', function($user, $object){
            return $user->owns($object);
        });

    }
}
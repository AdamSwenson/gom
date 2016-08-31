<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
//    public function boot(GateContract $gate)
    public function boot()
    {
        $this->registerPolicies();

        /*
       * Since there are not yet roles (e.g., teacher, TA) we don't yet need
       * any special policies that treat access, alteration, and deletion differently
       * or differently for different objects.
       * Thus these are just generic checks which can be used on any of the non-junction
       * based objects (i.e., exams, questions, elements, students, etc
       */

        Gate::define('access-object', function($user, $object){
//            var_dump($user->id);
//            var_dump($object->user_id);
//            var_dump($user->owns($object));
//            var_dump($object);

            return $user->owns($object);
        });

        Gate::define('alter-object', function($user, $object){
            return $user->owns($object);
        });

        Gate::define('destroy-object', function($user, $object){
            return $user->owns($object);
        });

//        $gate->define('access-object', function($user, $object){
//            return $user->owns($object);
//        });
//
//        $gate->define('alter-object', function($user, $object){
//            return $user->owns($object);
//        });
//
//        $gate->define('destroy-object', function($user, $object){
//            return $user->owns($object);
//        });

    }
}
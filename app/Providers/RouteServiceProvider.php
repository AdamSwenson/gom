<?php
namespace App\Providers;

use App\Element;
use App\Exam;
use App\GradeAssignment;
use App\Item;
use App\Kumi;
use App\Models\NewGom\Note;
use App\Models\NewGom\Tag;
use App\Question;
use App\Student;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

//        //binds route requests for model objects to the models
        Route::model('element', Element::class);
        Route::model('exam', Exam::class);
        Route::model('item', Item::class);
        Route::model('kumi', Kumi::class);
        Route::model('question', Question::class);
        Route::model('student', Student::class);
        Route::model('tag', Tag::class);
        Route::model('note', Note::class);
        Route::model('gradeassignment', GradeAssignment::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
                         'middleware' => 'web',
                         'namespace'  => $this->namespace,
                     ], function ($router)
        {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
                         'middleware' => 'api',
                         'namespace'  => $this->namespace,
                         'prefix'     => 'api',
                     ], function ($router)
        {
            require base_path('routes/api.php');
        });
    }
}
//}
//<?php
//
//namespace App\Providers;
//
//use Illuminate\Routing\Router;
//use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
//
//class RouteServiceProvider extends ServiceProvider
//{
//    /**
//     * This namespace is applied to the controller routes in your routes file.
//     *
//     * In addition, it is set as the URL generator's root namespace.
//     *
//     * @var string
//     */
//    protected $namespace = 'App\Http\Controllers';
//
//    /**
//     * Define your route model bindings, pattern filters, etc.
//     *
//     * @param  \Illuminate\Routing\Router  $router
//     * @return void
//     */
//    public function boot(Router $router)
//    {
//        //
//
//        parent::boot($router);
//
//        //binds route requests for model objects to the models
//        $router->model('element', 'App\Element');
//        $router->model('exam', 'App\Exam');
//        $router->model('question', 'App\Question');
//        $router->model('student', 'App\Student');
//    }
//
//    /**
//     * Define the routes for the application.
//     *
//     * @param  \Illuminate\Routing\Router  $router
//     * @return void
//     */
//    public function map(Router $router)
//    {
//        $router->group(['namespace' => $this->namespace], function ($router) {
//            require app_path('Http/routes.php');
//        });
//    }
//}

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('api', array('uses' => 'AjaxController@handleRequest'));
Route::post('setup/api', array('uses' => 'AjaxController@handleRequest'));

Route::get('home', 'LandingController@showLanding');

Route::get('landing', 'LandingController@showLanding');
Route::get('index', 'LandingController@showLanding');

Route::get('account/home', function(){
    return "Account home page";
});


Route::get('account/user_settings', function(){
    return "User settings page";
});
Route::get('account/preferences', function(){
    return "Preferences page";
});
Route::get('account/logout', function(){
    return "Logout";
});

Route::get('exammanager', array('uses' => 'InputController@showExamManager'));


Route::get('input', array('uses' => 'InputController@showInputPage'));


Route::get('instructions', function(){
   return 'instructions page';
});

Route::get('setup/exam', array('uses' => 'SetupController@showExamCreate', 'as' => 'examcreate'));

Route::get('setup/question', array('uses' => 'SetupController@showQuestionCreate', 'as' => 'questionsetup'));

Route::get('setup/element', array('uses' => 'SetupController@showElementCreate', 'as' => 'commentsetup' ));

Route::get('studentmanager', array('uses' => 'StudentController@showStudentUploader'));

Route::get('studentview', function(){
    return 'student view';
});

Route::get('report/analytics', function(){
    return "This will eventually be the analytics page";
});

Route::get('report/gradeassign', array('uses' => 'ReportController@showGradeAssign'));

Route::get('report/qualitycontrol', function(){
    return "This will eventually be the quality control page";
});

/* NEW routes for exam selection and creation below */
Route::resource('exam', 'ExamController');
/*
Route::get('exam', 'ExamController@index');
Route::get('exam/create', 'ExamController@create');
Route::post('exam', 'ExamController@store');
Route::get('exam/{id}', 'ExamController@show');
Route::get('exam/{id}/edit', 'ExamController@edit');
Route::patch('exam/{id}', 'ExamController@update');
Route::delete('exam/{id}', 'ExamController@destroy');
*/

/* Routes for questions */
Route::resource('question', 'QuestionController');
/*
Route::get('exam/{id}/question', 'QuestionController@index');
Route::get('exam/{id}/question/create', 'QuestionController@create');
Route::post('exam/{id}/question', 'QuestionController@store');
Route::get('exam/{id}/question/{id}', 'QuestionController@show');
Route::get('exam/{id}/question/edit', 'QuestionController@edit');
Route::patch('exam/{id}/question/{id}', 'QuestionController@update');
Route::delete('exam/{id}/question/{id}', 'QuestionController@destroy');
*/

/* Routes for Elements */
Route::resource('element', 'ElementController');
/*
Route::get('exam/{id}/question/{id}/element', 'ElementController@index');
Route::get('exam/{id}/question/{id}/element/create', 'ElementController@create');
Route::post('exam/{id}/question/{id}/element', 'ElementController@store');
Route::get('exam/{id}/question/{id}/element/{id}', 'ElementController@show');
Route::get('exam/{id}/question/{id}/element/edit', 'ElementController@edit');
Route::patch('exam/{id}/question/{id}/element/{id}', 'ElementController@update');
Route::delete('exam/{id}/question/{id}/element/{id}', 'ElementController@destroy');
*/

/* Routes for Rosters */

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

Route::post('account/home', 'LandingController@loggedIn');
Route::get('account/home', function(){
    return "Account home page";
});


Route::get('account/create','LandingController@accountCreate');

Route::post('account/confirm','LandingController@accountConfirm');



Route::get('account/user_settings', function(){
    return "User settings page";
});
Route::get('account/preferences', function(){
    return "Preferences page";
});
Route::get('account/logout', function(){
    return "Logout";
});

// Public routes for students to view
Route::get('studentview', function(){
    return 'student view';
});

// Reporting and analytics
Route::get('report/analytics', function(){
    return "This will eventually be the analytics page";
});

// Grading
Route::get('report/gradeassign', array('uses' => 'ReportController@showGradeAssign'));

// other
Route::get('report/qualitycontrol', function(){
    return "This will eventually be the quality control page";
});

/* NEW routes for exam selection and creation below */

Route::get('select','ExamController@index');
Route::resource('exam', 'ExamController');
/*
Route::get('exam', 'ExamController@index'); // get all exams for user
Route::get('exam/create', 'ExamController@create'); // display the create exam form
Route::post('exam', 'ExamController@store'); // save a new exam
Route::get('exam/{exam}', 'ExamController@show'); // show exam given by {id}
Route::get('exam/{exam}/edit', 'ExamController@edit'); // get form to edit element {id}
Route::patch('exam/{exam}', 'ExamController@update'); // save changes to element {id}
Route::delete('exam/{exam}', 'ExamController@destroy'); // delete element {id}
*/

/* Routes for questions */
Route::get('exam/{exam}/question/edit','QuestionController@edit');
Route::resource('exam.question', 'QuestionController');
/*
Route::get('exam/{id}/question', 'QuestionController@index');
Route::get('exam/{id}/question/create', 'QuestionController@create');
Route::post('exam/{id}/question', 'QuestionController@store');
Route::get('exam/{id}/question/{question}', 'QuestionController@show');
Route::get('exam/{id}/question/edit', 'QuestionController@edit');
Route::patch('exam/{id}/question/{question}', 'QuestionController@update');
Route::delete('exam/{id}/question/{question}', 'QuestionController@destroy');
*/

/* Routes for Elements */
Route::get('exam/{exam/question/{question}/element/edit','QuestionController@edit');
Route::resource('exam.question.element', 'ElementController');
/*
Route::get('exam/{id}/question/{id}/element', 'ElementController@index');
Route::get('exam/{id}/question/{id}/element/create', 'ElementController@create');
Route::post('exam/{id}/question/{id}/element', 'ElementController@store');
Route::get('exam/{id}/question/{id}/element/{id}', 'ElementController@show');
Route::get('exam/{id}/question/{id}/element/edit', 'ElementController@edit');
Route::patch('exam/{id}/question/{id}/element/{id}', 'ElementController@update');
Route::delete('exam/{id}/question/{id}/element/{id}', 'ElementController@destroy');
*/

Route::resource('roster', 'StudentController');

/*
Route::get('student', 'StudentController@index'); //get students
Route::get('student/create', 'StudentController@create'); // request form to create student
Route::post('student', 'StudentController@store'); // upload a new student
Route::get('student/{id}', 'StudentController@show'); // show student
Route::get('student/{id}/edit', 'StudentController@edit'); // edit a student given by {id}
Route::patch('student/{id}', 'StudentController@update'); //update given student
Route::delete('student/{id}', 'StudentController@destroy'); // delete student
*/

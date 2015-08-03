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

use App\Http\Controllers\PublicFeedbackController;

Route::get('/', function () {
    return view('welcome');
});

// Account
Route::get('account/user_settings', function(){
    return "User settings page";
});
Route::get('account/preferences', function(){
    return "Preferences page";
});
Route::get('account/logout', function(){
    return "Logout";
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

/* If arrived via link in email to student */
Route::get('feedback', 'StudentAccessController@show');
/* If arrived via feedback login page */
Route::post('feedback/login', 'StudentAccessController@show');

Route::get('feedback/make/{exam}', 'ReportController@createFeedback');

Route::get('feedback/view', 'PublicFeedbackController@showFeedback');



/* NEW routes for exam selection and creation below */
// Select exam page

Route::get('setup','ExamController@index');
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

Route::get('exam/{exam}/question/edit', array('as' =>'editAllQuestions', 'uses' => 'QuestionController@editAll'));
Route::post('exam/{exam}/question/updateAll', 'QuestionController@updateAll'); // updates all questions for the exam
Route::resource('exam.question', 'QuestionController');

/*
Route::get('exam/{id}/question', 'QuestionController@index');
Route::get('exam/{id}/question/create', 'QuestionController@create');
Route::post('exam/{id}/question', 'QuestionController@store');
Route::get('exam/{id}/question/{question}', 'QuestionController@show');
Route::get('exam/{id}/question/{question}/edit', 'QuestionController@edit');
Route::patch('exam/{id}/question/{question}', 'QuestionController@update');
Route::delete('exam/{id}/question/{question}', 'QuestionController@destroy');
*/

/* Routes for Elements */
Route::get('exam/{exam}/question/{question}/element/edit', array('as' => 'editAllElements', 'uses' => 'ElementController@editAll'));
Route::post('exam/{exam}/question/{question}/element/updateAll', 'ElementController@updateAll'); // update all elements for question
Route::resource('exam.question.element', 'ElementController');
/*
Route::get('exam/{id}/question/{id}/element', 'ElementController@index');
Route::get('exam/{id}/question/{id}/element/create', 'ElementController@create');
Route::post('exam/{id}/question/{id}/element', 'ElementController@store');
Route::get('exam/{id}/question/{id}/element/{id}', 'ElementController@show');
Route::get('exam/{id}/question/{id}/element/{id}/edit', 'ElementController@edit');
Route::patch('exam/{id}/question/{id}/element/{id}', 'ElementController@update');
Route::delete('exam/{id}/question/{id}/element/{id}', 'ElementController@destroy');
*/
Route::get('exam/{exam}/student/edit', array('as' => 'editAllStudents', 'uses' => 'StudentController@editAll'));
Route::resource('exam.student', 'StudentController');
/*
Route::get('exam/{exam}/student', 'StudentController@index'); //gets list of students for import / editing
Route::get('exam/{exam}/student/create', 'StudentController@create'); // request form to create a student
Route::post('exam/{exam}/student', 'StudentController@store'); // upload a new student
Route::get('exam/{exam}/student/{id}', 'StudentController@show'); // show student
Route::get('exam/{exam}/student/{id}/edit', 'StudentController@edit'); // edit a student given by {id}
Route::patch('exam/{exam}/student/{id}', 'StudentController@update'); //update given student
Route::delete('exam/{exam}/student/{id}', 'StudentController@destroy'); // delete student
*/

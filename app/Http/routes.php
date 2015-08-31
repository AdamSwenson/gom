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


Route::get('test', function () {
    return view('reports.grade_range_assignment');
  // return view('auth.reset');
});

/* Authentication and registration */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);


/* Account */
Route::post('account/home', 'LandingController@loggedIn');
Route::get('account/home', 'LandingController@loggedIn');

/* Home page */
Route::get('/', 'LandingController@showLanding');
Route::get('home', 'LandingController@showLanding');
Route::get('landing', 'LandingController@showLanding');
Route::get('index', 'LandingController@showLanding');

/* AJAX requests */
Route::post('api', array('uses' => 'AjaxController@handleRequest'));
Route::post('setup/api', array('uses' => 'AjaxController@handleRequest'));


/* ----------------------------------------------- Exam set up  -------------------------------------------------------- */
/* Select exam page */
Route::get('setup','ExamController@index');
Route::post('setup','ExamController@index');
Route::resource('exam', 'ExamController');

/* Routes for questions */
Route::get('exam/{exam}/question/edit', array('as' =>'editAllQuestions', 'uses' => 'QuestionController@editAll'));
Route::post('exam/{exam}/question/updateAll', 'QuestionController@updateAll'); // updates all questions for the exam
Route::resource('exam.question', 'QuestionController');

/* Routes for Elements */
Route::get('exam/{exam}/question/{question}/element/edit', array('as' => 'editAllElements', 'uses' => 'ElementController@editAll'));
Route::post('exam/{exam}/question/{question}/element/updateAll', 'ElementController@updateAll'); // update all elements for question
Route::resource('exam.question.element', 'ElementController');

/* Manage students */
Route::post('exam/{exam}/student/store', 'StudentController@store');
Route::get('exam/{exam}/student/update','StudentController@updateAll');
Route::get('exam/{exam}/student/edit', array('as' => 'editAllStudents', 'uses' => 'StudentController@editAll'));
Route::resource('exam.student', 'StudentController');


/* ------------------------------------------------ Grade exams ---------------------------------------------------------- */
//TODO Rework to be more coherent and restful
Route::get('grade', 'GradeController@index'); // present list of exams to grade.
Route::get('grade/exam/{exam}', 'GradeController@grade');  // begin grading the specified exam
Route::get('grade/exam/{exam}/student/{student}', 'GradeController@grade');  // begin grading the specified exam
Route::post('grade/exam/{exam}', 'GradeController@recordScore');
Route::get('grade/exam/{exam}/time','GradeController@loadTime');
Route::post('grade/exam/{exam}/time','GradeController@recordTime');
Route::get('grade/exam/{exam}/stats', 'GradeController@loadStats');

/* ----------------------------------------------- Reports --------------------------------------------------------------- */
/* Reporting and analytics */
Route::get('report', 'ReportController@showExams');
Route::get('report/{exam}/gradeassign', array('uses' => 'ReportController@showGradeAssign'));
Route::get('report/{exam}/students', 'ReportController@showStudents'); // shows student controls for the exam
Route::get('report/{exam}/students/{student}', 'ReportController@showStudentFeedback'); // show feedback for the student
Route::post('report/{exam}/students/{student}', 'ReportController@notifyStudent'); // email the student with feedback
Route::get('report/{exam}/release', 'ReportController@releaseExam'); // releases {exam}
Route::get('report/{exam}/unrelease', 'ReportController@unreleaseExam'); // delete student access and set to unreleased
Route::get('report/{exam}/analytics','ReportController@showAnalytics');
Route::get('report/{exam}/qualitycontrol', 'ReportController@showQualityControl');



/* Feedback */
//If arrived via link in email to student
Route::get('feedback', 'PublicFeedbackController@showFeedback');
//Route::get('feedback', 'StudentAccessController@show');
// If arrived via feedback login page */
Route::post('feedback/login', 'StudentAccessController@show');
Route::get('feedback/make/{exam}', 'ReportController@createFeedback');
Route::get('feedback/view', 'PublicFeedbackController@showFeedback');







/* Account */
//Route::post('account/home', 'LandingController@loggedIn');
//Route::get('account/home', 'LandingController@loggedIn');

//register account
//Route::get('account/create','LandingController@accountCreate');
//Route::post('account/confirm','LandingController@accountConfirm');
//Route::get('account/retrieve','LandingController@retrievePassword');
//Route::post('account/sent','LandingController@sentPassword');

//// Authentication routes...
//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
//
//// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');




/*
Route::get('exam/{id}/question', 'QuestionController@index');
Route::get('exam/{id}/question/create', 'QuestionController@create');
Route::post('exam/{id}/question', 'QuestionController@store');
Route::get('exam/{id}/question/{question}', 'QuestionController@show');
Route::get('exam/{id}/question/{question}/edit', 'QuestionController@edit');
Route::patch('exam/{id}/question/{question}', 'QuestionController@update');
Route::delete('exam/{id}/question/{question}', 'QuestionController@destroy');
*/

/*
Route::get('exam/{id}/question/{id}/element', 'ElementController@index');
Route::get('exam/{id}/question/{id}/element/create', 'ElementController@create');
Route::post('exam/{id}/question/{id}/element', 'ElementController@store');
Route::get('exam/{id}/question/{id}/element/{id}', 'ElementController@show');
Route::get('exam/{id}/question/{id}/element/{id}/edit', 'ElementController@edit');
Route::patch('exam/{id}/question/{id}/element/{id}', 'ElementController@update');
Route::delete('exam/{id}/question/{id}/element/{id}', 'ElementController@destroy');
*/



/*
Route::get('exam/{exam}/student', 'StudentController@index'); //gets list of students for import / editing
Route::get('exam/{exam}/student/create', 'StudentController@create'); // request form to create a student
Route::post('exam/{exam}/student', 'StudentController@store'); // upload a new student
Route::get('exam/{exam}/student/{id}', 'StudentController@show'); // show student
Route::get('exam/{exam}/student/{id}/edit', 'StudentController@edit'); // edit a student given by {id}
Route::patch('exam/{exam}/student/{id}', 'StudentController@update'); //update given student
Route::delete('exam/{exam}/student/{id}', 'StudentController@destroy'); // delete student
*/

/*
Route::get('exam', 'ExamController@index'); // get all exams for user
Route::get('exam/create', 'ExamController@create'); // display the create exam form
Route::post('exam', 'ExamController@store'); // save a new exam
Route::get('exam/{exam}', 'ExamController@show'); // show exam given by {id}
Route::get('exam/{exam}/edit', 'ExamController@edit'); // get form to edit element {id}
Route::patch('exam/{exam}', 'ExamController@update'); // save changes to element {id}
Route::delete('exam/{exam}', 'ExamController@destroy'); // delete element {id}
*/


//Route::get('account/user_settings', function(){
//    return "User settings page";
//});
//Route::get('account/preferences', function(){
//    return "Preferences page";
//});
//Route::get('account/logout', function(){
//    return "Logout";
//});


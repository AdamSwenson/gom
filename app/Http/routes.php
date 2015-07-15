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

Route::get('account/create', function(){
    return "Account create";
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

//////////////////////
//HSVersion Addition//
//////////////////////

//Route::get('home')
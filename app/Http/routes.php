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

Route::get('landing', 'LandingController@showLanding');

Route::get('setup/exam', array('uses' => 'SetupController@showExamCreate', 'as' => 'examcreate'));

Route::get('setup/question', array('uses' => 'SetupController@showQuestionCreate', 'as' => 'questionsetup'));
Route::get('setup/element', array('uses' => 'SetupController@showElementCreate', 'as' => 'commentsetup' ));

Route::get('input', array('uses' => 'InputController@showPage', 'as' => 'inputm'));


Route::get('newExam/jip', array('as' => 'api', function(){
   return 'jip NEW EXAM content';
}));


Route::get('api/{examid}', function($examid){
   return "The exam id is: $examid";
});

Route::get('newnewexam', function(){
   return Redirect::route('api');
});
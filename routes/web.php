<?php

/*
|--------------------------------------------------------------------------
| Grade Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/* ---------------------------- Authentication and registration ------------------------------------------------------*/

use App\Http\Controllers\Item\KumiController;
use App\Http\Controllers\Time\TimeController;

Route::auth();
//temp until convert everything to use the post
Route::get('/logout', 'Auth\LoginController@logout');

/* Temporary: Limitations on registration */
Route::get('registrationRestrictions', 'RestrictedRegistrationController@showRestrictedAccessPage')->name('show-restricted-registration-page');
Route::post('registrationRestrictions', 'RestrictedRegistrationController@recordInterestToWaitlist');


/* --------------------------------------------- Account -------------------------------------------------------------*/
Route::get('account', 'LandingController@loggedIn');

/* ----------------------------------------------- Exam set up  ----------------------------------------------------- */
/* Routes for exam */
Route::get('exam/{exam}/clone', 'ExamController@cloneExam');
Route::resource('exam', 'ExamController');

/* Routes for questions */
Route::get('exam/{exam}/question/edit', array('as' => 'editAllQuestions', 'uses' => 'QuestionController@editAll'));
Route::post('exam/{exam}/question/updateAll', 'QuestionController@updateAll'); // updates all questions for the exam
Route::resource('exam.question', 'QuestionController');

/* Routes for Elements */
Route::get('exam/{exam}/question/{question}/element/edit', array('as' => 'editAllElements', 'uses' => 'ElementController@editAll'));
Route::post('exam/{exam}/question/{question}/element/updateAll', 'ElementController@updateAll'); // update all elements for question
Route::resource('exam.question.element', 'ElementController');

/* Manage students */
Route::post('exam/{exam}/student/store', 'StudentController@store');
Route::post('exam/{exam}/student/updateAll', 'StudentController@updateAll');
Route::get('exam/{exam}/student/edit', array('as' => 'editAllStudents', 'uses' => 'StudentController@editAll'));
Route::resource('exam.student', 'StudentController');


/* ------------------------------------------------ Grade exams ----------------------------------------------------- */
//TODO Rework to be more coherent and restful
/* Grade exam */
// present list of exams to grade.
Route::get('grade', 'GradeController@index');
// begin grade the specified exam
Route::get('grade/exam/{exam}', 'GradeController@grade');

/* Grade assignment */
// launch grade assigner
Route::get('grade/exam/{exam}/assign', 'Grade\GradeAssignmentController@assign');
// record grade assignments
Route::post('grade/exam/{exam}/assign', 'Grade\GradeAssignmentController@recordAssignments');

/* Api */
// record a question or element score
Route::post('grade/exam/{exam}', 'Grade\ScoreController@recordScore');

// delete a question or element score
Route::delete('grade/exam/{exam}', 'Grade\ScoreController@removeScore');


/* -----------------------------------------------  Home   ---------------------------------------------------------- */
/* Home page - now called 'landing' */
Route::get('/', 'LandingController@showLanding');
Route::get('index', 'LandingController@showLanding'); //re-added since stuff may redirect here
Route::get('landing', 'LandingController@showLanding'); //re-added since stuff seems to redirect here
//the place to be redirected after registration etc
Route::get('home', 'ExamController@index');


/* -----------------------------------------------  Info   ---------------------------------------------------------- */
//about
Route::get('about', 'InfoController@showAbout');
//contact
Route::get('contact', 'InfoController@showContact');
//faq
Route::get('info/faq', 'InfoController@showFaq');
Route::get('faq', 'InfoController@showFaq');
//instructions
Route::get('info/instructions', 'InfoController@showInstructions');
Route::get('help', 'InfoController@showInstructions');
//tutorials
Route::get('info/tutorials', 'InfoController@showTutorials');
Route::get('tutorials', 'InfoController@showTutorials');
Route::get('gettingStarted', 'InfoController@showGettingStarted');


/* ----------------------------------------------- Reports ---------------------------------------------------------- */
/* Reporting and analytics pages */
// Report index page
Route::get('report', 'Report\ReportController@index');
// Analytics page
Route::get('report/{exam}/analytics', 'Report\AnalyticsController@index');
// Quality control tools
Route::get('report/{exam}/qualitycontrol', 'Quality\QualityControlController@index');
// shows student controls for the exam
Route::get('report/{exam}/students', 'Report\ReportController@showStudentControls');


/* Feedback */
// show feedback for the student
Route::get('report/{exam}/students/{student}', 'Report\ReportController@showStudentFeedback');
// show feedback for all students on one page
Route::get('report/{exam}/feedback/all', 'Report\ReportController@showFeedbackForAllStudentsOnExam');


/* Notifications */
// email a student with their feedback link
Route::post('report/{exam}/students/{student}', 'Report\ReportController@notifyStudent');
// releases {exam} to all students
Route::post('report/{exam}/release', 'Report\ReportController@releaseExam');
// delete student access and set to unreleased
Route::post('report/{exam}/unrelease', 'Report\ReportController@unreleaseExam');


/* ------------------------------------------------- Feedback --------------------------------------------------------*/
/* Creation */
Route::get('feedback/make/{exam}', 'Report\ReportController@createFeedback');

/* Public access (i.e., student arriving) */
// If arrived via link in email to student
Route::get('feedback', 'Report\PublicFeedbackController@showFeedback');
// If arrived via feedback login page
Route::post('feedback/login', 'Report\PublicFeedbackController@showFeedback');
Route::get('feedback/login', 'Report\PublicFeedbackController@showLogin');
Route::get('feedback/view', 'Report\PublicFeedbackController@showFeedback');


// Export exam scores in csv
Route::get('backup/{exam}', 'UtilityController@exportExamScores');
// Make sure stats stored in redis are up to date
Route::get('utilities/updateExamCounts', 'UtilityController@updateExamCounts');


/* ---------------------------------------------- Time --------------------------------------------------------- */
Route::post('grade/exam/{exam}/time', 'Time\TimeController@recordTime');
Route::get('time/exam/{exam}', 'Time\TimeController@getGradingTimes');


/* ---------------------------------------------- Testing ----------------------------------------------------------- */
#Route::get('testing/gradingSliders', 'TestController@gradingSlidersTest');
#Route::get('dev/newgrading', 'TestController@newGrading');

Route::get('dev/test', 'TestController@test');
//Route::get('dev/home', 'TestController@home');
//Route::get('dev/newsetup', 'TestController@newSetup');


//We never ask for a question or element with the show method/route
//so we define the show route to use the exam id. This will get hit
//before the resource show route below. However, if somehow this route
//didn't get hit, we may have a problem.
//When we want those directly, we use the edit route


/* ******************** New setup page ***************** */
//display of page
Route::get('dev/setup/{exam}', 'Item\SetupController@show')->name('show-exam');
Route::get('dev/setup', 'Item\SetupController@index');
//order of the items on the exam
Route::post('dev/setup/{exam}/order', 'Item\AssignmentController@store');

//intrinsic properties of the item
//Route::put('items/{item}', 'ItemController@update');
//Route::patch('items/{exam}', 'ItemController@updateAll');
Route::resource('items', 'Item\ItemController'); //,
Route::put('editexam/{exam}', 'Item\ItemController@examUpdate');

Route::post('comments/{item}', 'Item\CommentController@store');

//new exam controller
Route::get('dev/exams', 'Item\ExamResourceController@index');
Route::put('dev/exam/{exam}', 'Item\ExamResourceController@update');

//new student controller for intrinsic props of student objects
Route::resource('dev/students', 'Item\StudentResourceController');

//associations between student and exam
Route::post('dev/roster/{student}/assoc/{kumi}', 'Item\RosterController@associateStudent');
Route::post('dev/roster/{student}/diss/{kumi}', 'Item\RosterController@disassociateStudent');

//Grade assignments
//retrieve assignments for a particular exam
Route::get('dev/grade-assignment/exam/{exam}', 'Grade\GradeAssignmentController@show');
// update grade assignments
Route::post('dev/grade-assignment/{gradeassignment}', 'Grade\GradeAssignmentController@update');


//History
Route::get('dev/history/item/{item}', 'Item\ItemHistoryController@show');

//Kumi
Route::resource('dev/kumis', 'Item\KumiController');
Route::get('dev/kumis/exam/{exam}', 'Item\KumiController@loadExamKumi');
Route::post('dev/kumis/{kumi}/exam/{exam}/new', 'Item\KumiController@loadExamKumi');


//Notes
Route::post('dev/notes/item/{item}', 'Item\NotesController@store');
Route::get('dev/notes/item/{item}', 'Item\NotesController@showForItem');
Route::post('dev/notes/exam/{exam}', 'Item\NotesController@store');
Route::get('dev/notes/exam/{exam}', 'Item\NotesController@showForExam');
Route::resource('dev/notes', 'Item\NotesController');


//Scores
Route::get('dev/scores/student/{student}', 'Item\ItemScoreController@studentScores');
Route::get('dev/scores/item/{item}', 'Item\ItemScoreController@itemScores');
Route::get('dev/scores/exam/{exam}', 'Item\ItemScoreController@examScores');
Route::post('dev/scores', 'Item\ItemScoreController@store');

Route::get('dev/analytics/total-scores/exam/{exam}', 'Analytics\TotalScoreController@getTotalScoresForExam');

//Stats (i.e., scores without identifying the student and statistical summaries )
Route::get('dev/stats/item/{item}', 'Item\ItemStatsController@itemScores');
Route::get('dev/stats/exam/{exam}', 'Item\ItemStatsController@examScores');
Route::get('dev/stats/summary/item/{item}', 'Item\ItemStatsController@itemSummary');
Route::get('dev/stats/summary/exam/{exam}', 'Item\ItemStatsController@examSummary');
Route::get('dev/stats/summary/exam/{exam}/item/{item}', 'Item\ItemStatsController@itemSummaryForExam');
Route::get('dev/stats/summary/kumi/item/{item}', 'Item\ItemStatsController@itemSummaryByKumi');

Route::get('dev/numgraded/exam/{exam}', 'Analytics\ExamCountsController@getExamCounts');

//Quality control
Route::get('quality/exam/{exam}', 'Quality\QualityControlController@show');

//Students
Route::post('dev/roster/anon/{exam}', 'Item\RosterController@anonymizeStudents');
Route::get('dev/roster/exam/{exam}', 'Item\RosterController@getStudentsForExam');


//Tags
//-- tag-item
Route::post('dev/tags/item/{item}/tag/{tag}', 'Item\TagsController@associateTagWithItem');
Route::delete('dev/tags/item/{item}/tag/{tag}', 'Item\TagsController@disassociateTagFromItem');
Route::get('dev/tags/item/{item}', 'Item\TagsController@showForItem');
//-- tag-exam
Route::post('dev/tags/exam/{exam}/tag/{tag}', 'Item\TagsController@associateTagWithExam');
Route::delete('dev/tags/exam/{exam}/tag/{tag}', 'Item\TagsController@disassociateTagFromExam');
Route::get('dev/tags/exam/{exam}', 'Item\TagsController@showForExam');
//-- tag-student
Route::post('dev/tags/student/{student}/tag/{tag}', 'Item\TagsController@associateTagWithStudent');
Route::delete('dev/tags/student/{student}/tag/{tag}', 'Item\TagsController@disassociateTagFromStudent');
Route::get('dev/tags/student/{student}', 'Item\TagsController@showForStudent');

Route::resource('dev/tags', 'Item\TagsController');

// ====================================== NEW GRADING
Route::get('dev/time/exam/{exam}/student/{student}', 'Time\TimeController@show');
Route::post('dev/time/exam/{exam}/student/{student}', 'Time\TimeController@post');
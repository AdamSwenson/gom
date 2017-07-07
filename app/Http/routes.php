<?php
//
///*
//|--------------------------------------------------------------------------
//| Application Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register all of the routes for an application.
//| It's a breeze. Simply tell Laravel the URIs it should respond to
//| and give it the controller to call when that URI is requested.
//|
//*/
//
//Route::get('info/instructions', 'InfoController@showInstructions');
//Route::get('info/faq', 'InfoController@showFaq');
//Route::get('info/tutorials', 'InfoController@showTutorials');
//
///* Authentication and registration */
//Route::auth();
////temp until convert everything to use the post
//Route::get('/logout', 'Auth\LoginController@logout');
////Route::controllers([
////    'auth' => 'Auth\AuthController',
////    'password' => 'Auth\PasswordController'
////]);
//
///* Home page - now called 'landing' */
//Route::get('/', 'LandingController@showLanding');
//Route::get('index', 'LandingController@showLanding'); //re-added since stuff may redirect here
//Route::get('landing', 'LandingController@showLanding'); //re-added since stuff seems to redirect here
//
//
///* Temporary: Limitations on registration */
//Route::get('registrationRestrictions', 'RestrictedRegistrationController@showRestrictedAccessPage');
//Route::post('registrationRestrictions', 'RestrictedRegistrationController@recordInterestToWaitlist');
//
//
///* --------------------------------------------- Account -------------------------------------------------------------*/
//Route::get('account', 'LandingController@loggedIn');
//
//
///* --------------------------------------------- Help ----------------------------------------------------------------*/
//Route::get('help', 'InfoController@showInstructions');
//Route::get('faq', 'InfoController@showFaq');
//Route::get('tutorials', 'InfoController@showTutorials');
//Route::get('gettingStarted', 'InfoController@showGettingStarted');
//
///* --------------------------------------------- About ---------------------------------------------------------------*/
//Route::get('about', 'InfoController@showAbout');
//
///* --------------------------------------------- Contact -------------------------------------------------------------*/
//Route::get('contact', 'InfoController@showContact');
//
//
///* ----------------------------------------------- Exam set up  ----------------------------------------------------- */
///* Routes for exam */
//Route::get('exam/{exam}/clone','ExamController@cloneExam');
//Route::resource('exam', 'ExamController');
//
///* Routes for questions */
//Route::get('exam/{exam}/question/edit', array('as' =>'editAllQuestions', 'uses' => 'QuestionController@editAll'));
//Route::post('exam/{exam}/question/updateAll', 'QuestionController@updateAll'); // updates all questions for the exam
//Route::resource('exam.question', 'QuestionController');
//
///* Routes for Elements */
//Route::get('exam/{exam}/question/{question}/element/edit', array('as' => 'editAllElements', 'uses' => 'ElementController@editAll'));
//Route::post('exam/{exam}/question/{question}/element/updateAll', 'ElementController@updateAll'); // update all elements for question
//Route::resource('exam.question.element', 'ElementController');
//
///* Manage students */
//Route::post('exam/{exam}/student/store', 'StudentController@store');
//Route::post('exam/{exam}/student/updateAll','StudentController@updateAll');
//Route::get('exam/{exam}/student/edit', array('as' => 'editAllStudents', 'uses' => 'StudentController@editAll'));
//Route::resource('exam.student', 'StudentController');
//
//
///* ------------------------------------------------ Grade exams ----------------------------------------------------- */
////TODO Rework to be more coherent and restful
///* Grade exam */
//// present list of exams to grade.
//Route::get('grade', 'GradeController@index');
//// begin grade the specified exam
//Route::get('grade/exam/{exam}', 'GradeController@grade');
//
///* Grade assignment */
//// launch grade assigner
//Route::get('grade/exam/{exam}/assign', 'Grade\GradeAssignmentController@assign');
//// record grade assignments
//Route::post('grade/exam/{exam}/assign', 'Grade\GradeAssignmentController@recordAssignments');
//
///* Api */
//// record a question or element score
//Route::post('grade/exam/{exam}', 'Api\ScoreController@recordScore');
//Route::post('grade/exam/{exam}/time', 'Api\TimeController@recordTime');
//// delete a question or element score
//Route::delete('grade/exam/{exam}', 'Api\ScoreController@removeScore');
//
///* ----------------------------------------------- Reports ---------------------------------------------------------- */
///* Reporting and analytics pages */
//// Report index page
//Route::get('report', 'Report\ReportController@index');
//// Analytics page
//Route::get('report/{exam}/analytics','Report\AnalyticsController@index');
//// Quality control tools
//Route::get('report/{exam}/qualitycontrol', 'Report\QualityControlController@index');
//// shows student controls for the exam
//Route::get('report/{exam}/students', 'Report\ReportController@showStudentControls');
//
//
///* Feedback */
//// show feedback for the student
//Route::get('report/{exam}/students/{student}', 'Report\ReportController@showStudentFeedback');
//// show feedback for all students on one page
//Route::get('report/{exam}/feedback/all', 'Report\ReportController@showFeedbackForAllStudentsOnExam');
//
//
///* Notifications */
//// email a student with their feedback link
//Route::post('report/{exam}/students/{student}', 'Report\ReportController@notifyStudent');
//// releases {exam} to all students
//Route::post('report/{exam}/release', 'Report\ReportController@releaseExam');
//// delete student access and set to unreleased
//Route::post('report/{exam}/unrelease', 'Report\ReportController@unreleaseExam');
//
//
///* ------------------------------------------------- Feedback --------------------------------------------------------*/
///* Creation */
//Route::get('feedback/make/{exam}', 'Report\ReportController@createFeedback');
//
///* Public access (i.e., student arriving) */
//// If arrived via link in email to student
//Route::get('feedback', 'Report\PublicFeedbackController@showFeedback');
//// If arrived via feedback login page
//Route::post('feedback/login', 'Report\PublicFeedbackController@showFeedback');
//Route::get('feedback/login', 'Report\PublicFeedbackController@showLogin');
//Route::get('feedback/view', 'Report\PublicFeedbackController@showFeedback');
//
//
///* ---------------------------------------------- Utilities --------------------------------------------------------- */
//// Export exam scores in csv
//Route::get('backup/{exam}', 'UtilityController@exportExamScores');
//// Make sure stats stored in redis are up to date
//Route::get('utilities/updateExamCounts', 'UtilityController@updateExamCounts');
//
//
///* ---------------------------------------------- Testing ----------------------------------------------------------- */
//Route::get('testing/gradingSliders', 'TestController@gradingSlidersTest');
//Route::get('Item/newgrading', 'TestController@newGrading');
////Route::get('Item/newsetup', 'TestController@newSetup');
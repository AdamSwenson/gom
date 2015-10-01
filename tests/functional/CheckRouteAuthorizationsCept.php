<?php
$I = new FunctionalTester($scenario);
$I->wantTo('Call every route that should require the user to be logged in without being logged in and get the appropriate error');


$actions_requiring_authentication = [

//    'LandingController@loggedIn',
    'ExamController@index',
    'ExamController@cloneExam',
    /* Routes for questions */
    'QuestionController@editAll',
    'QuestionController@updateAll',
    /* Routes for Elements */
    'ElementController@editAll',
    'ElementController@updateAll',
    /* Manage students */
    'StudentController@store',
    'StudentController@updateAll',
    'StudentController@editAll',
    /* Grade exams  */
    'GradeController@index',
    'GradeController@grade',
    'GradeController@assign',
    'GradeController@recordAssignments',
    'GradeController@recordScore',
    'GradeController@removeScore',
    'GradeController@loadTime',
    'GradeController@recordTime',
    'GradeController@loadStats',
    /*  Reports  */
    'ReportController@showExams',
    'ReportController@showGradeAssign',
    'ReportController@showStudents',
    'ReportController@showStudentFeedback',
    'ReportController@notifyStudent',
    'ReportController@releaseExam',
    'ReportController@unreleaseExam',
    'ReportController@showAnalytics',
    'ReportController@showQualityControl',
    /* Feedback */
    'ReportController@createFeedback',
];
$I->disableMiddleware();
//foreach ($actions_requiring_authentication as $act)
//{
//    $I->amOnAction($act);
//    $I->seeResponseCodeIs(503);
//}
$exam_owned_by_user = 1;
$question_owned_by_user = 1;
$routes_requiring_exam_ownership =[
  //  'ElementController@editAll',
    '/exam/1/question/1/element/edit',
    '/exam/1/question/1/element/updateAll'
];

//
//$I->amOnAction('ElementController@editAll', ['examId' => 1, 'questionId' => 1]);
//$I->seeResponseCodeIs(200);

foreach($routes_requiring_exam_ownership as $act)
{
//    //Good owner
//    \Illuminate\Support\Facades\Auth::loginUsingId(1);
//    $I->amOnPage($act);
//    $I->seeResponseCodeIs(200);
//
//    //Bad owner
//    \Illuminate\Support\Facades\Auth::logout();
//    \Illuminate\Support\Facades\Auth::loginUsingId(2);
//    $I->amOnAction($act);
//    $I->seeResponseCodeIs(403);

}
<?php
use App\Exam;
use App\User;

$I = new FunctionalTester($scenario);
$I->wantTo('Call every route that should require the user to own the relevant objects where the calling user does not own and get the appropriate error');

//necessary until fix laravel session problem
$I->disableMiddleware();

\Illuminate\Support\Facades\Auth::loginUsingId(1);

$owner = User::findOrFail(1);
$stranger = User::findOrNew(2);

$expected_error = 403;

$exam_owned_by_user = 1;
$question_owned_by_user = 1;
$element_owned_by_user = 1;
$student_owned_by_user = 1;

//Make sure works in the authorized case
$I->amLoggedAs($owner);
$I->amOnPage("/exam/1/clone");

$I->logout();
\Illuminate\Support\Facades\Auth::loginUsingId(2);
//$I->amLoggedAs($stranger);
$I->amOnPage("/exam/1/clone");
$I->seeResponseCodeIs($expected_error);


$routes_requiring_exam_ownership = [
//exam setup
    "/exam/$exam_owned_by_user/clone",
    "/exam/$exam_owned_by_user",
    "/exam/$exam_owned_by_user/edit",
// question setup
    "exam/$exam_owned_by_user/question/edit",
    "exam/$exam_owned_by_user/question/updateAll",
    "exam/$exam_owned_by_user/question",
    "exam/$exam_owned_by_user/question/create",
//student setup
    "exam/$exam_owned_by_user/student/store",
    "exam/$exam_owned_by_user/student/updateAll",
    "exam/$exam_owned_by_user/student/edit",
    "exam/$exam_owned_by_user/student",
    "exam/$exam_owned_by_user/student/create",
//grade
    "grade/exam/$exam_owned_by_user",
    "grade/exam/$exam_owned_by_user/assign",
    "grade/exam/$exam_owned_by_user/assign",
    "grade/exam/$exam_owned_by_user",
    "grade/exam/$exam_owned_by_user/remove",
    "grade/exam/$exam_owned_by_user/time",
    "grade/exam/$exam_owned_by_user/stats",
//report
    "report/$exam_owned_by_user/gradeassign",
    "report/$exam_owned_by_user/students",
    "report/$exam_owned_by_user/release",
    "report/$exam_owned_by_user/unrelease",
    "report/$exam_owned_by_user/analytics",
    "report/$exam_owned_by_user/qualitycontrol",
    "feedback/make/$exam_owned_by_user",
];

$routes_requiring_exam_and_other_ownership = [
    //setup
    "exam/$exam_owned_by_user/question/$question_owned_by_user",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/edit",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/edit",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/updateAll",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/create",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/$element_owned_by_user",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/$element_owned_by_user/edit",
    "exam/$exam_owned_by_user/question/$question_owned_by_user/element/$element_owned_by_user",
    "exam/$exam_owned_by_user/student/$student_owned_by_user",
    "exam/$exam_owned_by_user/student/$student_owned_by_user/edit",
    //student
    "grade/exam/$exam_owned_by_user/student/$student_owned_by_user",
    //feedback
    "report/$exam_owned_by_user/students/$student_owned_by_user",
];



$all_routes = $routes_requiring_exam_ownership + $routes_requiring_exam_and_other_ownership;
$I->logout();
$I->amLoggedAs($stranger);
/*
    Iterate through with a user who does not own the exam
    and make sure that throws error
*/
foreach($routes_requiring_exam_ownership as $act)
{
    $I->amOnPage($act);
    $I->seeResponseCodeIs($expected_error);
}


/*
Now we need to check that the authorization also is working on
owned objects in addition to the exam. So we will change the owner
of the exam but not the other objects, and should get the same errors.
*/
$exam = Exam::findOrFail($exam_owned_by_user);
$exam->user_id = $stranger->id;
$exam->save();

$I->logout();
$I->amLoggedAs($stranger);
foreach($routes_requiring_exam_and_other_ownership as $route)
{

    $I->amOnPage($act);
    $I->seeResponseCodeIs($expected_error);
}


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
    'ReportController@index',
    'ReportController@showQualityControl',
    /* Feedback */
    'ReportController@createFeedback',
];

/*
 * get all methods in controllers
 * $controllers = [];

foreach (Route::getRoutes()->getRoutes() as $route)
{
    $action = $route->getAction();

    if (array_key_exists('controller', $action))
    {
        // You can also use explode('@', $action['controller']); here
        // to separate the class name from the method
        $controllers[] = $action['controller'];
    }
}
 */
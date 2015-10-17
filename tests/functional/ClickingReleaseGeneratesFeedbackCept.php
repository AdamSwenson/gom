<?php
use App\Exam;

$I = new FunctionalTester($scenario);
$I->wantTo('Click release and have all feedback created');

\Illuminate\Support\Facades\Auth::loginUsingId(1);

$I->disableMiddleware();

// Open the page
$I->amOnPage('/report');

/* --------------------------------------- Check that opened correctly */
$I->seeInTitle("Reports | gradeomatic");
//See page description
$I->see("Reports & Release");

//See a release button for each of the user's exams
$exams = Exam::all();
$examIds = [];
foreach($exams as $exam)
{
    $examIds[] = $exam->getId();
}
$I->seeInFormFields('#form-id', $examIds);

//[
//<a class="btn btn-primary" id="exam6" style="width:140px;" title="Release Exam" data-released="6" onclick="confirmRelease(6)">
//            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
//Release Exam
//</a>
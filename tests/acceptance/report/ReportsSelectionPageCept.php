<?php
use App\Exam;

$I = new AcceptanceTester($scenario);
$I->wantTo('See all exams belonging to the user on the reports page' );

$I->test_login($I);
//\Illuminate\Support\Facades\Auth::loginUsingId(1);

////$I->disableMiddleware();
//
//// Open the page
//$I->amOnPage('/report');
//
///* --------------------------------------- Check that opened correctly */
//$I->seeInTitle("Reports | gradeomatic");
////See page description
//$I->see("Reports & Release");
//
//
//$exams = Exam::all();
//$examIds = [];
//foreach($exams as $exam)
//{
//    $examIds[] = $exam->getId();
//}
//$I->seeInFormFields('#form-id', $examIds);

//See a release button for each of the user's exams
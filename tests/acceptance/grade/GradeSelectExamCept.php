<?php
use Page\GradeSelectExamPage;

$examIdsWhichShouldSee = [1, 2, 4, 5, 6];
$examIdsWhichShouldNotSee = [3]; //belongs to user 2

//TODO Add (standardized) grading data to the tests
$examWithStudents = 1;


$I = new AcceptanceTester($scenario);
$I->wantTo('Open the exam selection page for grading and check that everything works');

$I->test_login($I);
$I->amOnPage(GradeSelectExamPage::$URL);
$I->wait(2);

$I->verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);

$I->amGoingTo("Click the grade button for an exam with students ");

$I->amGoingTo("Check that I am redirected to the grading page for exam #{$examWithStudents}");
$I->click(GradeSelectExamPage::gradeButtonXPath($examWithStudents));
$I->wait(2);
//check that on correct page
$I->seeInCurrentUrl(GradeSelectExamPage::gradeButtonTargetRoute($examWithStudents));
//back home
$I->amOnPage(GradeSelectExamPage::$URL);
$I->wait(2);
//make sure nothing changed
$I->verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);

$I->amGoingTo("Click the assign button for an exam with students and make sure I am properly redirected");
$I->click(GradeSelectExamPage::assignButtonXPath($examWithStudents));
$I->wait(2);
$I->seeInCurrentUrl(GradeSelectExamPage::assignButtonTargetRoute($examWithStudents));
//go home
$I->amOnPage(GradeSelectExamPage::$URL);
$I->wait(2);
$I->verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);



//$I->amGoingTo("Click the grade button for each exam and make sure I am properly redirected");
//    foreach($examIdsWhichShouldSee as $examId){
//        $I->amGoingTo("Check that I am redirected to the grading page for exam #{$examId}");
//            $I->click(GradeSelectExamPage::gradeButtonXPath($examId));
//            $I->wait(4);
//            //check that on correct page
//            $I->seeInCurrentUrl(GradeSelectExamPage::gradeButtonTargetRoute($examId));
//            //back home
//            $I->amOnPage(GradeSelectExamPage::$URL);
//            $I->wait(4);
//    }

//$I->amGoingTo("Click the assign button for each exam and make sure I am properly redirected");
//    foreach($examIdsWhichShouldSee as $examId){
//        $I->amGoingTo("Check that I am redirected to the grade assignment page for exam #{$examId}");
//        $I->click(GradeSelectExamPage::assignButtonXPath($examId));
//        $I->wait(2);
//        $I->seeInCurrentUrl(GradeSelectExamPage::assignButtonTargetRoute($examId));
//        //go home
//        $I->amOnPage(GradeSelectExamPage::$URL);
//        $I->wait(2);
//        $I->verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);
//    }



<?php
use Page\BootboxModals;
use Page\grade\GradeSelectExamPage;

$examWithNoQuestionsId = 5;
$examWithQuestionsButNoStudentsId = 6;
$examIdsWhichShouldSee = [1, 2, 4, 5, 6];
$examIdsWhichShouldNotSee = [3]; //belongs to user 2

//TODO Add (standardized) grading data to the tests
$examWithStudents = 1;

$scenario->group(['grade', 'index']);
$I = new AcceptanceTester($scenario);
$I->wantTo('Open the exam selection page for grading and check that everything works');

$I->test_login($I);
$I->amOnPage(GradeSelectExamPage::$URL);
$I->wait(2);

GradeSelectExamPage::verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);



$I->wantTo("Check that I am redirected to the grading page for exam #{$examWithStudents}");
    $I->amGoingTo("Click the grade button for an exam with students ");
    $I->click(GradeSelectExamPage::gradeButtonXPath($examWithStudents));
    $I->wait(2);
    $I->expectTo("be on the grading page for exam $examWithStudents");
    $I->seeInCurrentUrl(GradeSelectExamPage::gradeButtonTargetRoute($examWithStudents));

    $I->amGoingTo("Go back to the exam index page");
    $I->amOnPage(GradeSelectExamPage::$URL);
    $I->wait(2);

    $I->expect("that nothing has changed on the index page");
    GradeSelectExamPage::verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);


$I->wantTo("Click the assign button for an exam with students and make sure I am properly redirected");
    $I->amGoingTo("Click the assign button for an exam with students ");
    $I->click(GradeSelectExamPage::assignButtonXPath($examWithStudents));
    $I->wait(2);
    $I->expectTo("be on the assignment page for exam $examWithStudents");
    $I->seeInCurrentUrl(GradeSelectExamPage::assignButtonTargetRoute($examWithStudents));

    $I->amGoingTo("Go back to the exam index page");
    $I->amOnPage(GradeSelectExamPage::$URL);
    $I->wait(2);
    $I->expect("that nothing has changed on the index page");
    GradeSelectExamPage::verifyGradeExamSelectPageIntact($I, $examIdsWhichShouldSee, $examIdsWhichShouldNotSee);

$I->wantTo("Check that the appropriate error modal displays for attempting to GRADE exams without QUESTIONS and that I am not redirected");
    GradeSelectExamPage::setNumberStudents($I, $examWithQuestionsButNoStudentsId, '5');
    GradeSelectExamPage::setNumberQuestions($I, $examWithQuestionsButNoStudentsId, '0');
    $I->amGoingTo("Click the grade button for an exam with no questions ");
    $I->click(GradeSelectExamPage::gradeButtonXPath($examWithNoQuestionsId));
    BootboxModals::waitForBootboxModal($I, false);

    $I->expectTo("see the questions error text class and modal dismissal button");
    $I->seeElement(['css' => '.' . GradeSelectExamPage::$noQuestionsErrorClass]);
    $I->seeElement(GradeSelectExamPage::confirmButtonLocator());

    $I->amGoingTo("click the modal dismissal button");
    $I->click(GradeSelectExamPage::confirmButtonLocator());

    $I->expect("to no longer see the error modal");
    BootboxModals::waitForBootboxModal($I, false, true);

$I->wantTo("Check that the appropriate error modal displays for attempting to ASSIGN exams without QUESTIONS and that I am not redirected");
    GradeSelectExamPage::setNumberStudents($I, $examWithQuestionsButNoStudentsId, 5);
    GradeSelectExamPage::setNumberQuestions($I, $examWithQuestionsButNoStudentsId, 0);
    $I->amGoingTo("Click the assign button for an exam with no questions ");
    $I->click(GradeSelectExamPage::assignButtonXPath($examWithNoQuestionsId));
    BootboxModals::waitForBootboxModal($I, false);

    $I->expectTo("see the questions error text class and modal dismissal button");
    $I->seeElement(['css' => '.' . GradeSelectExamPage::$noQuestionsErrorClass]);
    $I->seeElement(GradeSelectExamPage::confirmButtonLocator());

    $I->amGoingTo("click the modal dismissal button");
    $I->click(GradeSelectExamPage::confirmButtonLocator());

    $I->expect("to no longer see the error modal");
    BootboxModals::waitForBootboxModal($I, false, true);
    

$I->wantTo("Check that the appropriate error modal displays for attempting to GRADE exams without STUDENTS and that I am not redirected");
    GradeSelectExamPage::setNumberStudents($I, $examWithQuestionsButNoStudentsId, 0);
    GradeSelectExamPage::setNumberQuestions($I, $examWithQuestionsButNoStudentsId, 5);
    $I->amGoingTo("Click the grade button for an exam with no students ");
    $I->click(['css' => '#gradeExam' . $examWithQuestionsButNoStudentsId]);
    BootboxModals::waitForBootboxModal($I);

    $I->expectTo("see the students error text class and modal dismissal button");
    $I->seeElement(['css' => '.' . GradeSelectExamPage::$noStudentsErrorClass]);
    $I->seeElement(GradeSelectExamPage::confirmButtonLocator());

    $I->amGoingTo("click the modal dismissal button");
    $I->click(GradeSelectExamPage::confirmButtonLocator());

    $I->expect("to no longer see the error modal");
    BootboxModals::waitForBootboxModal($I, false, true);


$I->wantTo("Check that the appropriate error modal displays for attempting to ASSIGN exams without STUDENTS and that I am not redirected");
    GradeSelectExamPage::setNumberQuestions($I, $examWithQuestionsButNoStudentsId, 5);
    GradeSelectExamPage::setNumberStudents($I, $examWithQuestionsButNoStudentsId, 0);
    $I->amGoingTo("Click the assign button for an exam with no students ");
    $I->click(GradeSelectExamPage::assignButtonXPath($examWithQuestionsButNoStudentsId));
    BootboxModals::waitForBootboxModal($I, false);

    $I->expectTo("see the students error text class and modal dismissal button");
    $I->seeElement(['css' => '.' . GradeSelectExamPage::$noStudentsErrorClass]);
    $I->seeElement(GradeSelectExamPage::confirmButtonLocator());

    $I->amGoingTo("click the modal dismissal button");
    $I->click(GradeSelectExamPage::confirmButtonLocator());

    $I->expect("to no longer see the error modal");
    BootboxModals::waitForBootboxModal($I, false, true);

$I->wantTo("Verify correct numbers are displayed for exam statistics");
    $scenario->incomplete('TODO Check exam statistics displayed properly');


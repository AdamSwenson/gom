<?php
use Page\BootboxModals;
use Page\grade\GradeSelectExamPage;
use Page\grade\GradingPage;
use Page\grade\GradeAssignPage;

class GradeSelectExamCest
{
    public $examWithNoQuestionsId = 5;
    public $examWithQuestionsButNoStudentsId = 6;
    public $examIdsWhichShouldSee = [1, 2, 4, 5, 6];
    public $examIdsWhichShouldNotSee = [3]; //belongs to user 2

//TODO Add (standardized) grading data to the tests
    public $examWithStudents = 1;

    public function _before(AcceptanceTester $I)
    {
        $I->test_login($I);
        $I->amOnPage(GradeSelectExamPage::$URL);
        $I->waitForElementVisible(GradeSelectExamPage::$mainBodyLocator);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group grade
     * @group index
     * @param AcceptanceTester $I
     */
    public function updateCounts(AcceptanceTester $I){
        $I->amGoingTo('make sure the exam1 stats are up to date. This is not really a test. just prepping. only needs to run once. thus not going in _before');
        $I->amOnPage('utilities/updateExamCounts');
        $I->wait(10);
    }

    /**
     * @group grade
     * @group index
     * @param AcceptanceTester $I
     */
    public function verifyIntact(AcceptanceTester $I)
    {
        GradeSelectExamPage::verifyGradeExamSelectPageIntact($I, $this->examIdsWhichShouldSee, $this->examIdsWhichShouldNotSee);
    }


    /**
     * @group grade
     * @group index
     * @param AcceptanceTester $I
     */
    public function checkStatsDisplayed(AcceptanceTester $I){

        $I->wantTo("Verify correct numbers are displayed for exam1 statistics");

        // $scenario->incomplete('TODO Check exam1 statistics displayed properly');
    }

    /**
     * @group grade
     * @group index
     * @param AcceptanceTester $I
     */
    public function checkRedirectToGrading(AcceptanceTester $I)
    {
        $I->wantTo("Check that I am redirected to the grading page for exam1 #{$this->examWithStudents}");
        $I->amGoingTo("Click the grade button for an exam1 with students ");
        $I->click(GradeSelectExamPage::gradeButtonLocator($this->examWithStudents));

        $I->expectTo("be on the grading page for exam1 {$this->examWithStudents}");
        $I->waitForElementVisible(GradingPage::$mainBodyLocator);
        $I->seeInCurrentUrl(GradeSelectExamPage::gradeButtonTargetRoute($this->examWithStudents));
    }

    /**
     * @group grade
     * @group index
     * @param AcceptanceTester $I
     */
    public function checkRedirectToAssignment(AcceptanceTester $I)
    {
        $I->wantTo("Click the assign button for an exam1 with students and make sure I am properly redirected");
        $I->amGoingTo("Click the assign button for an exam1 with students ");
        $I->click(GradeSelectExamPage::assignButtonLocator($this->examWithStudents));

        $I->expectTo("be on the assignment page for exam1 {$this->examWithStudents}");
        $I->waitForElementVisible(GradeAssignPage::$mainBodyLocator);
        $I->seeInCurrentUrl(GradeSelectExamPage::assignButtonTargetRoute($this->examWithStudents));
    }


//    /**
//     * @group grade
//     * @group index
//     * @param AcceptanceTester $I
//     */
//    public function checkErrorForGradingExamsWithNoQuestions(AcceptanceTester $I)
//    {
//        $I->wantTo("Check that the appropriate error modal displays for attempting to GRADE exams without QUESTIONS and that I am not redirected");
//        GradeSelectExamPage::setNumberStudents($I, $this->examWithQuestionsButNoStudentsId, '5');
//        GradeSelectExamPage::setNumberQuestions($I, $this->examWithQuestionsButNoStudentsId, '0');
//        $I->amGoingTo("Click the grade button for an exam1 with no questions ");
//        $I->click(GradeSelectExamPage::gradeButtonXPath($this->examWithNoQuestionsId));
//        BootboxModals::waitForBootboxModal($I, false);
//
//        $I->expectTo("see the questions error text class and modal dismissal button");
//        $I->seeElement(['css' => '.' . GradeSelectExamPage::$noQuestionsErrorClass]);
//        $I->seeElement(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->amGoingTo("click the modal dismissal button");
//        $I->click(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->expect("to no longer see the error modal");
//        BootboxModals::waitForBootboxModal($I, false, true);
//
//    }
//
//    /**
//     * @group grade
//     * @group index
//     * @param AcceptanceTester $I
//     */
//    public function checkErrorForAssigningExamsWithNoQuestions(AcceptanceTester $I)
//    {
//        $I->wantTo("Check that the appropriate error modal displays for attempting to ASSIGN exams without QUESTIONS and that I am not redirected");
//        GradeSelectExamPage::setNumberStudents($I, $this->examWithQuestionsButNoStudentsId, 5);
//        GradeSelectExamPage::setNumberQuestions($I, $this->examWithQuestionsButNoStudentsId, 0);
//        $I->amGoingTo("Click the assign button for an exam1 with no questions ");
//        $I->click(GradeSelectExamPage::assignButtonXPath($this->examWithNoQuestionsId));
//        BootboxModals::waitForBootboxModal($I, false);
//
//        $I->expectTo("see the questions error text class and modal dismissal button");
//        $I->seeElement(['css' => '.' . GradeSelectExamPage::$noQuestionsErrorClass]);
//        $I->seeElement(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->amGoingTo("click the modal dismissal button");
//        $I->click(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->expect("to no longer see the error modal");
//        BootboxModals::waitForBootboxModal($I, false, true);
//
//    }
//
//    /**
//     * @group grade
//     * @group index
//     * @param AcceptanceTester $I
//     */
//    public function checkErrorForGradingExamsWithNoStudents(AcceptanceTester $I)
//    {
//        $I->wantTo("Check that the appropriate error modal displays for attempting to GRADE exams without STUDENTS and that I am not redirected");
//        GradeSelectExamPage::setNumberStudents($I, $this->examWithQuestionsButNoStudentsId, 0);
//        GradeSelectExamPage::setNumberQuestions($I, $this->examWithQuestionsButNoStudentsId, 5);
//        $I->amGoingTo("Click the grade button for an exam1 with no students ");
//        $I->click(['css' => '#gradeExam' . $this->examWithQuestionsButNoStudentsId]);
//        BootboxModals::waitForBootboxModal($I);
//
//        $I->expectTo("see the students error text class and modal dismissal button");
//        $I->seeElement(['css' => '.' . GradeSelectExamPage::$noStudentsErrorClass]);
//        $I->seeElement(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->amGoingTo("click the modal dismissal button");
//        $I->click(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->expect("to no longer see the error modal");
//        BootboxModals::waitForBootboxModal($I, false, true);
//
//    }
//
//
//    /**
//     * @group grade
//     * @group index
//     * @param AcceptanceTester $I
//     */
//    public function checkErrorForAssigningExamsWithNoStudents(AcceptanceTester $I)
//    {
//
//        $I->wantTo("Check that the appropriate error modal displays for attempting to ASSIGN exams without STUDENTS and that I am not redirected");
//        GradeSelectExamPage::setNumberQuestions($I, $this->examWithQuestionsButNoStudentsId, 5);
//        GradeSelectExamPage::setNumberStudents($I, $this->examWithQuestionsButNoStudentsId, 0);
//        $I->amGoingTo("Click the assign button for an exam1 with no students ");
//        $I->click(GradeSelectExamPage::assignButtonXPath($this->examWithQuestionsButNoStudentsId));
//        BootboxModals::waitForBootboxModal($I, false);
//
//        $I->expectTo("see the students error text class and modal dismissal button");
//        $I->seeElement(['css' => '.' . GradeSelectExamPage::$noStudentsErrorClass]);
//        $I->seeElement(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->amGoingTo("click the modal dismissal button");
//        $I->click(GradeSelectExamPage::confirmButtonLocator());
//
//        $I->expect("to no longer see the error modal");
//        BootboxModals::waitForBootboxModal($I, false, true);
//
//    }
}

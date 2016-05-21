<?php
use App\Student;
use Page\report\StudentControlsPage;

/**
 * Make sure see expected view when no students are present
 * Class StudentControlsWhenNoStudentsCest
 */
class StudentControlsWhenNoStudentsCest
{
    public $examWithoutStudentsId = 6;

    public function _before(FunctionalTester $I)
    {
        $I->logIn($I);
        $I->amOnPage(StudentControlsPage::URL($this->examWithoutStudentsId));
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function checkPageIntact(FunctionalTester $I)
    {
        $I->seeInCurrentUrl(StudentControlsPage::route($this->examWithoutStudentsId));
        $I->see(StudentControlsPage::$pageTitleText);
        $I->see(StudentControlsPage::$pageHeadingText);
        $I->see(StudentControlsPage::$pageSubHeadingText);

    }

    public function noStudentsMessageDisplayed(FunctionalTester $I)
    {
        $I->seeElement(['css' => StudentControlsPage::$noStudentsMessageClassName]);
        $I->see(StudentControlsPage::$noStudentsMessageText);

    }
}

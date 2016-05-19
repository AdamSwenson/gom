<?php

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
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function checkPageIntact(FunctionalTester $I)
    {
    }

    public function noStudentsMessageDisplayed(FunctionalTester $I)
    {

    }
}

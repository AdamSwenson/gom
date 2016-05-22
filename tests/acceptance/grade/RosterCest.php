<?php


class RosterCest
{
    public $examId = 2; //nothing graded
    public $studentRowId = 1;
    public $studentNumber = 2;//the number which will be in the name of the student
    public $numQuestions = 5;
    public $numElements = 5;
    public $maxScore = 100;

    public function _before(AcceptanceTester $I)
    {
        GradingPage::navigateToGradingPage($I, $this->examId);

    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function selectedStudentRowHighlighting(AcceptanceTester $I)
    {
        $I->wantTo("check that the selected student's row is hightlighted and no other student row is highlighted");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->wait(1);

    }


    public function gradedStudentRowHighlighting()
    {
        
    }
    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function checkGradeBlind(AcceptanceTester $I)
    {
        $I->wantTo("Click the grade blind icon and see that the student names are hidden");

    }

}

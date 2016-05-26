<?php


use Page\grade\GradingPage;
use Page\grade\RosterArea;

class RosterCest
{
    public $examId = 2; //nothing graded
    public $studentRowId = 1;
    public $studentNumber = 2;//the number which will be in the name of the student
    public $numStudents = 5;
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


    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function selectedStudentRowHighlighting(AcceptanceTester $I)
    {
        $I->wantTo("check that the selected student's row is highlighted and no other student row is highlighted");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->wait(1);

        for($i=0; $i<$this->numStudents; $i++){
            if($i === $this->studentRowId){
                RosterArea::assertRowIsMarkedActive($I, $i );
            }
            else{
                RosterArea::assertRowIsUnaltered($I, $i );
            }
        }
    }

    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function switchActiveStudentAndCheckHighlighting(AcceptanceTester $I){
        $newActiveRowIndex = $this->studentRowId + 1;
        GradingPage::clickStudentRow($I, $newActiveRowIndex);
        $I->wait(1);

        for($i=0; $i<$this->numStudents; $i++){
            if($i === $this->studentRowId){
                $I->expect("that the previously selected row is now inactive");
                RosterArea::assertRowIsUnaltered($I, $i);
            }
            elseif ($i === $newActiveRowIndex){
                RosterArea::assertRowIsMarkedActive($I, $i);
            }
            else{
                RosterArea::assertRowIsUnaltered($I, $i);
            }
        }
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

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
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function selectedStudentRowHighlighting(AcceptanceTester $I)
    {
        $I->wantTo("check that the selected student's row is highlighted and no other student row is highlighted");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->wait(1);

        for($i=0; $i<$this->numStudents; $i++){
            if($i == $this->studentRowId){
                RosterArea::assertRowIsMarkedActive($I, $i );
            }
            else{
                RosterArea::assertRowIsMarkedActive($I, $i, true );
            }
        }
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function switchActiveStudentAndCheckHighlighting(AcceptanceTester $I){
        $I->amGoingTo('click the initial student row and check that it changes state');
        GradingPage::clickStudentRow($I, $this->studentRowId);
        RosterArea::assertRowIsMarkedActive($I, $this->studentRowId );

        $I->amGoingTo('click a new row and check that it changes state.');
        $newActiveRowIndex = $this->studentRowId + 1;
        GradingPage::clickStudentRow($I, $newActiveRowIndex);
        RosterArea::assertRowIsMarkedActive($I, $newActiveRowIndex );

        $I->amGoingTo('make sure the previously clicked row has gone back to normal');
        for($i=0; $i<$this->numStudents; $i++){
            if($i === $this->studentRowId){
                $I->expect("that the previously selected row is now inactive");
                RosterArea::assertRowIsMarkedActive($I, $i, true);
            }
            elseif ($i === $newActiveRowIndex){
                $I->expect("the newly selected row is active");
                RosterArea::assertRowIsMarkedActive($I, $i);
            }
            else{
                $I->expect("rows which haven't been clicked are inactive");
                RosterArea::assertRowIsMarkedActive($I, $i, true);
//                RosterArea::assertRowIsUnaltered($I, $i);
            }
        }
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function gradedStudentRowHighlighting(AcceptanceTester $I)
    {
        $I->amGoingTo('enter a question score for a previously ungraded student ');
        RosterArea::assertRowIsMarkedGraded($I, $this->studentRowId, true );
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->fillField(GradingPage::questionScoreFieldLocator(1), 92);

        $I->amGoingTo("select another student");
        GradingPage::clickStudentRow($I, $this->studentRowId + 1);

        $I->expect("the student is now marked as graded");
        RosterArea::assertRowIsMarkedGraded($I, $this->studentRowId);

        $I->amGoingTo("reload the page to check that the graded student is still marked as graded");
        $I->reloadPage();
        $I->wait(2);
        RosterArea::assertRowIsMarkedGraded($I, $this->studentRowId);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function checkGradeBlind(AcceptanceTester $I)
    {
        $I->wantTo("Click the grade blind icon and see that the student names are hidden");

        $I->expect("that the names and grades are not hidden");
        RosterArea::assertNamesAreHidden($I, $this->numStudents, true);

        $I->amGoingTo("click the hide button");
        $I->click(RosterArea::$nameVisibilityControlButtonLocator);

        $I->expect("that the names and grades are hidden");
        RosterArea::assertNamesAreHidden($I, $this->numStudents);

        $I->amGoingTo("click the hide button to unhide the names");
        $I->click(RosterArea::$nameVisibilityControlButtonLocator);

        $I->expect("that the names and grades are not hidden");
        RosterArea::assertNamesAreHidden($I, $this->numStudents, true);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     * @group typeAhead
     */
    public function checkTypeaheadName(AcceptanceTester $I){
        $I->expect("not to see the typeahead list");
        $I->dontSeeElement(RosterArea::$typeaheadNameDropdownListLocator);

        $I->expect("not to see the target student marked active");
        RosterArea::assertRowIsMarkedActive($I, 0, true);

        $I->amGoingTo("start typing in the student name box");
        $I->fillField(GradingPage::$activeStudentNameFieldLocator, "last");
        $I->wait(2);

        $I->expectTo("see the typeahead list");
        $I->seeElement(RosterArea::$typeaheadNameDropdownListLocator);

        $I->amGoingTo("click the first item on the dropdown list");
        $I->click(['css' => "#activeStudentNameArea > ul > li.active > a"]);
        $I->wait(2);

        $I->expectTo("see that the first student is now active");
        RosterArea::assertRowIsMarkedActive($I, 0);

//        $I->expect("the dropdown list to have hidden");
//        $I->dontSeeElement(RosterArea::$typeaheadNameDropdownListLocator);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     * @group typeAhead
     */
    public function checkTypeaheadId(AcceptanceTester $I){
        $I->expect("not to see the typeahead list");
        $I->dontSeeElement(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expect("not to see the target student marked active");
        RosterArea::assertRowIsMarkedActive($I, 2, true);

        $I->amGoingTo("start typing in the student identifier box");
        $I->fillField(GradingPage::$activeStudentIdFieldLocator, 3);
        $I->wait(2);

        $I->expectTo("see the typeahead list");
        $I->seeElement(RosterArea::$typeaheadIdDropdownListLocator);

        $I->amGoingTo("click the first item on the dropdown list");
        $I->click(['css' => "#activeStudentIdentifierArea > ul > li.active > a"]);
        $I->wait(2);

        $I->expectTo("see that the student with id 333333333 is now active");
        RosterArea::assertRowIsMarkedActive($I, 2);

//        $I->expect("the dropdown list to have hidden");
//        $I->dontSeeElement(RosterArea::$typeaheadIdDropdownListLocator);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function checkTableSortingByName(AcceptanceTester $I){
        $I->expect("that the students are initially in alphabetical order (descending)");
        for($i=0; $i<$this->numStudents; $i++){
            $I->see( RosterArea::expectedStudentName($i + 1), RosterArea::studentNameLocator($i));
            $I->see( RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
        }

        $I->amGoingTo("click the name area to sort by name");
        $I->click(RosterArea::$tableHeaderNameLocator);
        $I->wait(1);

        $I->expectTo("see the names of students in ascending order");
        $j = $this->numStudents - 1; //4
        for($i=$j; $i>=0; $i--){
            $I->see(RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
            $I->see(RosterArea::expectedStudentName($i + 1), RosterArea::studentNameLocator($i));
        }

        $I->amGoingTo("click the name area to sort by name again");
        $I->click(RosterArea::$tableHeaderNameLocator);
        $I->wait(1);

        $I->expect("that the students are again in alphabetical order (descending)");
        for($i=0; $i<$this->numStudents; $i++){
            $I->see(RosterArea::expectedStudentName($i + 1), RosterArea::studentNameLocator($i));
        }
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function checkTableSortingById(AcceptanceTester $I){
        $I->expect("that the students are initially in numeric order by ids(descending)");
        for($i=0; $i<$this->numStudents; $i++){
            $I->see( RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
        }

        $I->amGoingTo("click the id header area to sort by id");
        $I->click(RosterArea::$tableHeaderIdLocator);
        $I->wait(1);

        $I->expectTo("see the ids of students in ascending order");
        $j = $this->numStudents - 1; //4
        for($i=$j; $i>=0; $i--){
            $I->see(RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
            $I->see(RosterArea::expectedStudentName($i + 1), RosterArea::studentNameLocator($i));
        }

        $I->amGoingTo("click the id header area to sort by id again");
        $I->click(RosterArea::$tableHeaderIdLocator);
        $I->wait(1);

        $I->expect("that the students are again in numeric order (descending)");
        for($i=0; $i<$this->numStudents; $i++){
            $I->see(RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
            $I->see(RosterArea::expectedStudentName($i + 1), RosterArea::studentNameLocator($i));
        }
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     * @incomplete
     */
    public function checkTableSortingByGrade(AcceptanceTester $I){

    }
}

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

        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            if ( $i == $this->studentRowId )
            {
                RosterArea::assertRowIsMarkedActive($I, $i);
            } else
            {
                RosterArea::assertRowIsMarkedActive($I, $i, true);
            }
        }
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function switchActiveStudentAndCheckHighlighting(AcceptanceTester $I)
    {
        $I->amGoingTo('click the initial student row and check that it changes state');
        GradingPage::clickStudentRow($I, $this->studentRowId);
        RosterArea::assertRowIsMarkedActive($I, $this->studentRowId);

        $I->amGoingTo('click a new row and check that it changes state.');
        $newActiveRowIndex = $this->studentRowId + 1;
        GradingPage::clickStudentRow($I, $newActiveRowIndex);
        RosterArea::assertRowIsMarkedActive($I, $newActiveRowIndex);

        $I->amGoingTo('make sure the previously clicked row has gone back to normal');
        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            if ( $i === $this->studentRowId )
            {
                $I->expect("that the previously selected row is now inactive");
                RosterArea::assertRowIsMarkedActive($I, $i, true);
            } elseif ( $i === $newActiveRowIndex )
            {
                $I->expect("the newly selected row is active");
                RosterArea::assertRowIsMarkedActive($I, $i);
            } else
            {
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
        RosterArea::assertRowIsMarkedGraded($I, $this->studentRowId, true);
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
    public function gradedStudentRowHighlightingMultiple(AcceptanceTester $I)
    {
        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            $I->amGoingTo('enter a question score for a previously ungraded student ');
            RosterArea::assertRowIsMarkedGraded($I, $i, true);
            GradingPage::clickStudentRow($I, $i);
            $I->fillField(GradingPage::questionScoreFieldLocator(1), 92);

            $I->amGoingTo("select another student");
            $next = $i == $this->numStudents - 1 ? 0 : $i + 1;
            GradingPage::clickStudentRow($I, $next);

            $I->amGoingTo("reload the page to check that the graded student is still marked as graded");
            $I->reloadPage();
            foreach ( range(0, $i) as $v )
            {
                RosterArea::assertRowIsMarkedGraded($I, $v);
            }
        }
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
    public function checkTypeaheadName(AcceptanceTester $I)
    {
        $I->expect("not to see the typeahead list");
        $I->dontSeeElement(RosterArea::$typeaheadNameDropdownListLocator);

        $I->expect("not to see the target student marked active");
        RosterArea::assertRowIsMarkedActive($I, 0, true);

        $I->amGoingTo("start typing in the student name box");
        $I->fillField(GradingPage::$activeStudentNameFieldLocator, "last");
        $I->waitForElementVisible(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expectTo("see the typeahead list");
        $I->seeElement(RosterArea::$typeaheadNameDropdownListLocator);

        $I->amGoingTo("click the first item on the dropdown list");
        $I->click(RosterArea::$typeaheadIdDropdownListLocator);
        $I->waitForElementNotVisible(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expectTo("see that the first student is now active");
        RosterArea::assertRowIsMarkedActive($I, 0);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     * @group typeAhead
     */
    public function checkTypeaheadId(AcceptanceTester $I)
    {
        $I->expect("not to see the typeahead list");
        $I->dontSeeElement(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expect("not to see the target student marked active");
        RosterArea::assertRowIsMarkedActive($I, 2, true);

        $I->amGoingTo("start typing in the student identifier box");
        $I->fillField(GradingPage::$activeStudentIdFieldLocator, 3);
        $I->waitForElementVisible(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expectTo("see the typeahead list");
        $I->seeElement(RosterArea::$typeaheadIdDropdownListLocator);

        $I->amGoingTo("click the first item on the dropdown list");
        $I->click(RosterArea::$typeaheadIdDropdownListLocator);

        $I->expectTo("see that the student with id 333333333 is now active");
        $I->waitForElementNotVisible(RosterArea::$typeaheadIdDropdownListLocator);
        RosterArea::assertRowIsMarkedActive($I, 2);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function checkTableSortingByName(AcceptanceTester $I)
    {
        $I->expect("that the students are initially in alphabetical order (ascending)");
        for ( $i = 1; $i <= $this->numStudents; $i++ )
        {
            $I->see(RosterArea::expectedStudentName($i), RosterArea::studentNameLocator($i - 1));
            $I->see(RosterArea::expectedStudentId($i), RosterArea::studentIdLocator($i - 1));

            $I->expect("that the rows are correctly ordered too");
            $I->see(RosterArea::expectedStudentName($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(1)"]);
            $I->see(RosterArea::expectedStudentId($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(2)"]);
        }

        $I->amGoingTo("click the name area to sort by name into descending order");
        $I->click(RosterArea::$tableHeaderNameLocator);
        $I->wait(1);

        $I->expect("that the students are in alphabetical order (descending)");
        $k = 1;
        $j = $this->numStudents; //5
        for ( $i = $j; $i > 0; $i-- )
        {
            //first line should be student w id #5
            $I->see(RosterArea::expectedStudentName($i), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(1)"]);
            $I->see(RosterArea::expectedStudentId($i), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(2)"]);
            $k++;
        }

        $I->amGoingTo("click the name area to sort by name into ascending alphabetical order");
        $I->click(RosterArea::$tableHeaderNameLocator);
        $I->wait(1);

        $I->expectTo("see the names of students in ascending order");
        for ( $i = 1; $i <= $this->numStudents; $i++ )
        {
            $I->see(RosterArea::expectedStudentName($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(1)"]);
            $I->see(RosterArea::expectedStudentId($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(2)"]);
        }
        
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     */
    public function checkTableSortingById(AcceptanceTester $I)
    {
        $I->expect("that the students are initially in numeric order by ids(ascending)");
        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            $I->see(RosterArea::expectedStudentId($i + 1), RosterArea::studentIdLocator($i));
        }

        $I->amGoingTo("click the id header area to sort by id");
        $I->click(RosterArea::$tableHeaderIdLocator);
        $I->wait(1);

        $I->expect("that the students are in numeric order by id (descending)");
        $k = 1;
        $j = $this->numStudents - 1; //4
        for ( $i = $j; $i >= 0; $i-- )
        {
            //sorting on '--' is non-deterministic, so skip students 1 and 2
            if ( $i + 1 > 2 )
            {
                //first line should be student w id #5
                $I->see(RosterArea::expectedStudentName($i + 1), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(1)"]);
                $I->see(RosterArea::expectedStudentId($i + 1), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(2)"]);
            }
            $k++;
        }

        $I->amGoingTo("click the id header area to sort by id into ascending order");
        $I->click(RosterArea::$tableHeaderIdLocator);
        $I->wait(1);


        $I->expectTo("see the ids of students in ascending order");
        for ( $i = 1; $i <= $this->numStudents; $i++ )
        {
            //sorting on '--' is non-deterministic, so skip students 1 and 2
            if ( $i > 2 )
            {
                $I->see(RosterArea::expectedStudentName($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(1)"]);
                $I->see(RosterArea::expectedStudentId($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(2)"]);
            }
        }

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group rosterArea
     * @group dev
     */
    public function checkTableSortingByGrade(AcceptanceTester $I)
    {
        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            $I->amGoingTo('enter a question score for a previously ungraded student ');
            GradingPage::clickStudentRow($I, $i);
            $I->fillField(GradingPage::questionScoreFieldLocator(1), $i);

            $I->amGoingTo("select another student");
            $next = $i == $this->numStudents - 1 ? 0 : $i + 1;
            GradingPage::clickStudentRow($I, $next);
        }

        $I->amGoingTo("check that the roster table is showing the grades");
        for ( $i = 0; $i < $this->numStudents; $i++ )
        {
            $I->seeElement(RosterArea::studentGradeLocator($i));
            $I->see($i, RosterArea::studentGradeLocator($i));
        }

        $I->amGoingTo("click the sort by grade header");
        $I->click(RosterArea::$tableHeaderGradeLocator);
        $I->wait(2);

        $I->expectTo("see the students in descending order by grade");
        $k = 1; //this will count up
        $j = $this->numStudents - 1; //4
        for ( $i = $j; $i >= 0; $i-- )
        {
            //student #5 should have the highest score; student #1 should have the lowest
            $I->see(RosterArea::expectedStudentName($i + 1), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(1)"]);
            $I->see(RosterArea::expectedStudentId($i + 1), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(2)"]);
            $I->see(floatval($i), ['css' => "tr.studentListItem:nth-child({$k}) > td:nth-child(3)"]);
            $k++; //$k is counting rows from the top
        }


        $I->amGoingTo("click the grade header again");
        $I->click(RosterArea::$tableHeaderGradeLocator);
        $I->wait(2);

        $I->expectTo("see the students in ascending order by grade");
        for ( $i = 1; $i <= $this->numStudents; $i++ )
        {
            //student #1/0 should have the lowest score and be in the highest row
            $I->see(RosterArea::expectedStudentName($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(1)"]);
            $I->see(RosterArea::expectedStudentId($i), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(2)"]);
            $I->see(floatval($i - 1), ['css' => "tr.studentListItem:nth-child({$i}) > td:nth-child(3)"]);
        }


    }
}

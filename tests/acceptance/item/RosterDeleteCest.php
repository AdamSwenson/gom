<?php
use Page\setup\ExamEditPage;
use Page\setup\RosterEditPage;

class ItemRosterDeleteCest
{
    public $students;
    public $examId;

    public function _before(AcceptanceTester $I)
    {
        $this->students = RosterEditPage::students1Through5();
        #Exam with questions is exam #1
        $this->examId = $I->examIdWithQuestions();

        $I->wantTo("Remove a roster and see that all students on it were removed from all tables");
        RosterEditPage::navigateToPage($I, $this->examId);

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        RosterEditPage::verifyRosterEditPageIntact($I);
        RosterEditPage::verifyInitialValuesPresent($I);
    }


    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function clickDeleteAndCancel(AcceptanceTester $I)
    {
        $I->amGoingTo("Click the roster delete button but cancel ");

        $I->expect("that the confirmation modal is not visible");
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);

        $I->amGoingTo("click the delete button");
        $I->click(RosterEditPage::$deleteRosterButtonLocator);
        $I->waitForElementVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expectTo('see the roster deletion confirmation modal');
        $I->seeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->see(RosterEditPage::$deleteRosterWarningModalText);
        $I->seeElement(RosterEditPage::$rosterDeleteConfirmButtonLocator);
        $I->seeElement(RosterEditPage::$rosterDeleteCancelButtonLocator);

        $I->amGoingTo("click cancel");
        $I->click(RosterEditPage::$rosterDeleteCancelButtonLocator);
        $I->waitForElementNotVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expect('that the roster deletion confirmation modal has closed');
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
        $I->dontSeeElement(RosterEditPage::$rosterDeleteConfirmButtonLocator);
        $I->dontSeeElement(RosterEditPage::$rosterDeleteCancelButtonLocator);

        $I->expect("that the student rows are still present");
        for ( $i = 1; $i <= 5; $i++ )
        {
            $v = $this->students[ $i ];
            $I->seeInField("form input[type=text]", $v['last']);
            $I->seeInField("form input[type=text]", $v['first']);
            if ( ! is_null($v['sid']) )
            {
                $I->seeInField("form input[type=text]", $v['sid']);
            }
            if ( ! is_null($v['email']) )
            {
                $I->seeInField("form input[type=text]", $v['email']);
            }
        }

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function deleteRoster(AcceptanceTester $I)
    {
        $I->wantTo("Remove all students associated with the exam");

        $I->expect("that the confirmation modal is not visible");
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);

        $I->amGoingTo("click the delete button");
        $I->click(RosterEditPage::$deleteRosterButtonLocator);
        $I->waitForElementVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expectTo('see the roster deletion confirmation modal');
        $I->seeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->see(RosterEditPage::$deleteRosterWarningModalText);
        $I->seeElement(RosterEditPage::$rosterDeleteConfirmButtonLocator);
        $I->seeElement(RosterEditPage::$rosterDeleteCancelButtonLocator);

        $I->amGoingTo("click confirm");
        $I->click(RosterEditPage::$rosterDeleteConfirmButtonLocator);
        $I->waitForElementNotVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expect('that the roster deletion confirmation modal has closed');
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
        $I->dontSeeElement(RosterEditPage::$rosterDeleteConfirmButtonLocator);
        $I->dontSeeElement(RosterEditPage::$rosterDeleteCancelButtonLocator);


        $I->expect('that the post-deletion message is displayed');
        $I->waitForElementVisible(RosterEditPage::$postDeleteModalLocator);
        $I->see(RosterEditPage::$postDeleteMessage);

        $I->amGoingTo('close the post deletion message');
        $I->click(RosterEditPage::$postDeleteMessageCloseButtonLocator);
        $I->waitForElementNotVisible(RosterEditPage::$postDeleteModalLocator);

        $I->expect("that the post delete message is no longer visible");
        $I->dontSee(RosterEditPage::$postDeleteMessage);

        $I->expectTo('see that all the rows have been removed');
        $I->dontSeeElement(['xpath' => '//*[@id="studentRosterBody"]/tr']);
        for ( $i = 1; $i <= 5; $i++ )
        {
            $v = $this->students[ $i ];
            $I->dontSee($v['last']);
            $I->dontSee($v['first']);
            if ( ! is_null($v['sid']) )
            {
                $I->dontSee($v['sid']);
            }
            if ( ! is_null($v['email']) )
            {
                $I->dontSee($v['email']);
            }
        }


        $I->amGoingTo("Submit the form");
        $I->click(RosterEditPage::$forwardNavLocator);
        $I->waitForElementVisible(ExamEditPage::$mainBodyLocator);

        $I->expect("to have been redirected to the edit exam page");
        $I->seeInCurrentUrl("exam/{$this->examId}/edit");

//TODO Do I want to check other tables to make sure the removal cascaded?
        $I->expect("that all the students were removed from the database");
        for ( $i = 1; $i <= 5; $i++ )
        {
            $v = $this->students[ $i ];
            $record = [
                'user_id'    => 1,
                'last_name'  => $v['last'],
                'first_name' => $v['first'],
            ];

            if ( ! is_null($v['sid']) )
            {
                $record['student_identifier'] = $v['sid'];
            }
            if ( ! is_null($v['email']) )
            {
                $record['email'] = $v['email'];
            }

            $I->dontSeeInDatabase('students', $record);
        }

    }

}
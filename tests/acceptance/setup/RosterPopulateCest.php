<?php

use Page\setup\RosterEditPage;


class RosterPopulateCest
{

public $examWithQuestionsId = 1;
#Exam with no questions is exam #4
public $examId;

    public function _before(AcceptanceTester $I)
    {
        $this->examId =  $I->examIdNoQuestions();;
        //Log in
        $I->test_login($I);
        $I->wait(2);
# Go to page
        $I->amOnPage("/exam/{$this->examId}/student/edit");
        $I->wait(3);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        RosterEditPage::verifyRosterEditPageIntact($I);
    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function simulateUpload(AcceptanceTester $I)
    {
        //Submit file
        $I->amGoingTo("Simulate uploading a file");
        $I->attachFile(RosterEditPage::$importRosterButton, 'acceptance_test_roster.csv');
        $I->click(RosterEditPage::$importRosterButton);

        $I->amGoingTo("Check that all the data in the spreadsheet are represented on the page");
        $I->seeInField("form input[type=text]", "student1last");
        $I->seeInField("form input[type=text]", "student2last");
        $I->seeInField("form input[type=text]", "student3last");
        $I->seeInField("form input[type=text]", "student4last");
        $I->seeInField("form input[type=text]", "student5last");

        $I->seeInField("form input[type=text]", "student1first");
        $I->seeInField("form input[type=text]", "student2first");
        $I->seeInField("form input[type=text]", "student3first");
        $I->seeInField("form input[type=text]", "student4first");
        $I->seeInField("form input[type=text]", "student5first");

        $I->seeInField("form input[type=text]", "111111111");
        $I->seeInField("form input[type=text]", "222222222");
        $I->seeInField("form input[type=text]", "333333333");

        $I->seeInField("form input[type=text]", "student1@email.com");
        $I->seeInField("form input[type=text]", "student2@email.com");
        $I->seeInField("form input[type=text]", "student4@email.com");

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function submitForm(AcceptanceTester $I)
    {
        $I->amGoingTo("Submit the form");
        $I->click(RosterEditPage::$forwardNavButton);

# Properly redirected
        /* If there are no questions on the exam, it will redirect to the edit exam
         * Otherwise, the default destination is the edit elements page.
         *
         * Since we've created a brand-new exam for this, we should go to the edit exam
         * page
         */
        $I->amGoingTo("Verify that I was properly redirected");
        $I->seeInTitle("Edit Exam | gradeomatic");
        $I->seeInCurrentUrl("exam/{$this->examId}/edit");
//$I->see('5 students added');

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function checkInDb(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();

        $I->amGoingTo("Check that all the students were saved to the database");
        $I->seeInDatabase('students', ['user_id' => 1,
                                       'last_name' => 'student1last',
                                       'first_name' => 'student1first',
                                       'student_identifier' => 111111111,
                                       'email' => 'student1@email.com']);

        $I->seeInDatabase('students', ['user_id' => 1,
                                       'last_name' => 'student2last',
                                       'first_name' => 'student2first',
                                       'student_identifier' => 222222222,
                                       'email' => 'student2@email.com']);

        $I->seeInDatabase('students', ['user_id' => 1,
                                       'last_name' => 'student3last',
                                       'first_name' => 'student3first',
                                       'student_identifier' => 333333333]);

        $I->seeInDatabase('students', ['user_id' => 1,
                                       'last_name' => 'student4last',
                                       'first_name' => 'student4first',
                                       'email' => 'student4@email.com']);


        $I->seeInDatabase('students', ['user_id' => 1,
                                       'last_name' => 'student5last',
                                       'first_name' => 'student5first']);

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function checkRedirection(AcceptanceTester $I){


        $I->amGoingTo("Check that we will get the default redirection experience if the exam has questions");
        # Go to page
        $I->amOnPage("/exam/{$this->examWithQuestionsId}/student/edit");
        $I->wait(2);
        // Make sure seeing what should
        RosterEditPage::verifyRosterEditPageIntact($I);
        RosterEditPage::verifyInitialValuesPresent($I);
        //Submit file
        $I->attachFile('#fileInput', 'acceptance_test_roster.csv');
        $I->click("#backNavButton");

        $I->seeInTitle("Edit Elements | gradeomatic");
        //since we don't need to know which question id is involved, we split this
        //between two lines
        //the actual url would be http://localhost:8000/exam/3/question/15/element/edit
        $I->seeInCurrentUrl("/exam/{$this->examWithQuestionsId}/question");
        $I->seeInCurrentUrl("/element/edit");

    }

}

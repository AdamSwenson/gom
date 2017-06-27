<?php
use Page\ElementEditPage;
use Page\setup\ExamEditPage;
use Page\setup\RosterEditPage;


class ItemRosterEditCest
{
//$scenario->group(['roster', 'setup']);

//new row index (the index of the row that gets added when press add student)
    public $newRowIdx = 7;
    public $examId;

//new student
    public $newStudentLastName = 'newLastName';
    public $newStudentFirstName = 'newFirstName';
    public $newStudentSid = '9999';
    public $newStudentEmail = 'newStudentEmail@email.com';

//edited student
    public $editedStudentLastName = 'new_student3last';
    public $editedStudentFirstName = 'new_student3first';
    public $editedStudentEmail = 'new_student3@email.com';

    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Visit the roster edit page which already contains students, then make edits and see them in the database');
        
#Exam with no questions is exam #4
        $this->examId = $I->examIdWithQuestions();
        RosterEditPage::navigateToPage($I, $this->examId);
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function verifyIntact(AcceptanceTester $I)
    {
        RosterEditPage::verifyRosterEditPageIntact($I);
        RosterEditPage::verifyInitialValuesPresent($I);
    }

//$I->amGoingTo("Check that students have expected initial values");
//    $s = RosterEditPage::students1Through5();
//    for ( $i = 1; $i <= 5; $i++ )
//    {
//        $v = $s[ $i ];
//        $I->amGoingTo("tell you about " . $v['last']); //*[@id="lastName"]
//        $I->seeInField("//*[@id='lastName{$i}']", $v['last']);
//        $I->seeInField("//*[@id='firstName{$i}']", $v['first']);
//        if ( ! is_null($v['sid']) )
//        {
//            $I->seeInField("//*[@id='studentIdentifier{$i}']", $v['sid']);
//        }
//        if ( ! is_null($v['email']) )
//        {
//            $I->seeInField("//*[@id='email{$i}']", $v['email']);
//        }
//    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function deleteAndCancel(AcceptanceTester $I)
    {

        $I->amGoingTo("Start deleting the student in the second row but cancel the operation");
        $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);

        $I->click(['id' => "deleteStudentButton2"]);
        $I->waitForElementVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expectTo("see warning modal");
        $I->seeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->see(RosterEditPage::$deleteStudentWarningModalText);
        $I->seeElement(RosterEditPage::$deleteConfirmButtonLocator);
        $I->seeElement(RosterEditPage::$deleteCancelButtonLocator);

        $I->amGoingTo("click the cancel button");
        $I->click(RosterEditPage::$deleteCancelButtonLocator);
        $I->waitForElementNotVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expect("that the modal has closed and is no longer visible");
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);

        $I->expect("that the student row is still present");
        $I->seeInField("form input[type=text]", 'lastNameOfExisting2');
        $I->seeInField("form input[type=text]", 'firstNameOfExisting2');
        $I->seeInField("form input[type=text]", 'student2@email.com');

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function deleteStudent(AcceptanceTester $I)
    {
        $I->wantTo("Delete the student in the second row");

        $I->click(['id' => "deleteStudentButton2"]);
        $I->waitForElementVisible(RosterEditPage::$deleteConfirmationModalLocator);

        $I->expectTo("see warning modal");
        $I->seeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->see(RosterEditPage::$deleteStudentWarningModalText);
        $I->seeElement(RosterEditPage::$deleteConfirmButtonLocator);
        $I->seeElement(RosterEditPage::$deleteCancelButtonLocator);

        $I->amGoingTo("click the confirm button");
        $I->click(RosterEditPage::$deleteConfirmButtonLocator);
        $I->waitForElementNotVisible(RosterEditPage::$deleteConfirmationModalLocator);
//        $I->click('.deleteConfirmButton');

        $I->expect("that the modal has closed and is no longer visible");
        $I->dontSeeElement(RosterEditPage::$deleteConfirmationModalLocator);
        $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);
        
        $I->expect("that the student row is no longer present");
        $I->dontSeeInField("form input[type=text]", 'lastNameOfExisting2');
        $I->dontSeeInField("form input[type=text]", 'firstNameOfExisting2');
        $I->dontSeeInField("form input[type=text]", 'student2@email.com');

        $I->amGoingTo("submit the form");
        $I->click(RosterEditPage::$forwardNavLocator);
        $I->wait(5);

        $I->expect("that the deleted student has been removed from the db");
        $I->dontassertDatabaseHas('students',
                              [
                                  'user_id'    => 1,
                                  'last_name'  => 'lastNameOfExisting2',
                                  'first_name' => 'firstNameOfExisting2',
                                  'email'      => 'student2@email.com',
                              ]);


        $I->amGoingTo("Check that the unchanged students are still in the db");
        $I->assertDatabaseHas('students', [
            'user_id'    => 1,
            'last_name'  => 'lastNameOfExisting1',
            'first_name' => 'firstNameOfExisting1',
        ]);
        //student 2 was deleted
        //student 3 had all values changed. empty string replaced sid
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting4',
            'first_name'         => 'firstNameOfExisting4',
            'student_identifier' => '444444444',
            'email'              => 'student4@email.com',
        ]);
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting5',
            'first_name'         => 'firstNameOfExisting5',
            'student_identifier' => '555555555',
            'email'              => 'student5@email.com',
        ]);

    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function editStudent(AcceptanceTester $I)
    {
        $I->amGoingTo("Edit properties of the student in the third row");
        $I->fillField(['id' => "lastName3"], $this->editedStudentLastName);
        $I->fillField(['id' => "firstName3"], $this->editedStudentFirstName);
        $I->fillField(['id' => "studentIdentifier3"], ''); //replace existing w empty string
        $I->fillField(['id' => "email3"], $this->editedStudentEmail); //replace empty with string


        $I->amGoingTo("submit the form");
        $I->click(RosterEditPage::$forwardNavLocator);
        $I->wait(5);


        $I->amGoingTo("Check that the edited student is in the db");
        $I->assertDatabaseHas('students', [
            'user_id'    => 1,
            'last_name'  => $this->editedStudentLastName,
            'first_name' => $this->editedStudentFirstName,
            'email'      => $this->editedStudentEmail,
        ]);

        $I->amGoingTo("Check that the unchanged students are still in the db");
        $I->assertDatabaseHas('students', [
            'user_id'    => 1,
            'last_name'  => 'lastNameOfExisting1',
            'first_name' => 'firstNameOfExisting1',
        ]);
        //student 2 was deleted
        //student 3 had all values changed. empty string replaced sid
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting4',
            'first_name'         => 'firstNameOfExisting4',
            'student_identifier' => '444444444',
            'email'              => 'student4@email.com',
        ]);
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting5',
            'first_name'         => 'firstNameOfExisting5',
            'student_identifier' => '555555555',
            'email'              => 'student5@email.com',
        ]);
    }

    /**
     * @group setup
     * @group roster
     * @param AcceptanceTester $I
     */
    public function addStudent(AcceptanceTester $I)
    {
        $I->amGoingTo("Add a student");
        //make sure empty row absent
        $I->dontSeeElement(['id' => "lastName{$this->newRowIdx}"]);
        $I->dontSeeElement(['id' => "firstName{$this->newRowIdx}"]);
        $I->dontSeeElement(['id' => "studentIdentifier{$this->newRowIdx}"]);
        $I->dontSeeElement(['id' => "email{$this->newRowIdx}"]);
        //click the button to add row
        $I->click(RosterEditPage::$addStudentButtonLocator);
        //confirm that see row
        $I->seeElement(['id' => "lastName{$this->newRowIdx}"]);
        $I->seeElement(['id' => "firstName{$this->newRowIdx}"]);
        $I->seeElement(['id' => "studentIdentifier{$this->newRowIdx}"]);
        $I->seeElement(['id' => "email{$this->newRowIdx}"]);
        //fill row
        $I->fillField(['id' => "lastName{$this->newRowIdx}"], $this->newStudentLastName);
        $I->fillField(['id' => "firstName{$this->newRowIdx}"], $this->newStudentFirstName);
        $I->fillField(['id' => "studentIdentifier{$this->newRowIdx}"], $this->newStudentSid);
        $I->fillField(['id' => "email{$this->newRowIdx}"], $this->newStudentEmail);
        //submit the form  
        $I->click(RosterEditPage::$forwardNavButton);
        # Properly redirected
        $I->seeInTitle('Edit Exam | gradeomatic');
        $I->seeInCurrentUrl("/exam/{$this->examId}/edit");
        //$I->seeInCurrentUrl("/exam/{$examId}/question/1/element/edit");

        $I->amGoingTo("Check that the new student is in the db");
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => $this->newStudentLastName,
            'first_name'         => $this->newStudentFirstName,
            'student_identifier' => $this->newStudentSid,
            'email'              => $this->newStudentEmail,
        ]);


        $I->amGoingTo("Check that the unchanged students are still in the db");
        $I->assertDatabaseHas('students', [
            'user_id'    => 1,
            'last_name'  => 'lastNameOfExisting1',
            'first_name' => 'firstNameOfExisting1',
        ]);
        //student 2 was deleted
        //student 3 had all values changed. empty string replaced sid
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting4',
            'first_name'         => 'firstNameOfExisting4',
            'student_identifier' => '444444444',
            'email'              => 'student4@email.com',
        ]);
        $I->assertDatabaseHas('students', [
            'user_id'            => 1,
            'last_name'          => 'lastNameOfExisting5',
            'first_name'         => 'firstNameOfExisting5',
            'student_identifier' => '555555555',
            'email'              => 'student5@email.com',
        ]);

    }


}
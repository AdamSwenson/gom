<?php
use Page\ElementEditPage;
use Page\ExamEditPage;
use Page\RosterEditPage;

$scenario->group(['roster', 'setup']);

//new row index (the index of the row that gets added when press add student)
$newRowIdx = 7;

//new student
$newStudentLastName = 'newLastName';
$newStudentFirstName = 'newFirstName';
$newStudentSid = '9999';
$newStudentEmail = 'newStudentEmail@email.com';

//edited student
$editedStudentLastName = 'new_student3last';
$editedStudentFirstName = 'new_student3first';
$editedStudentEmail = 'new_student3@email.com';



$I = new AcceptanceTester($scenario);

$I->wantTo('Visit the roster edit page which already contains students, then make edits and see them in the database');
#Exam with no questions is exam #4
$examId = $I->examIdWithQuestions();
//Log in
$I->test_login($I);
# Go to page
$I->amOnPage("/exam/{$examId}/student/edit");
$I->wait(2);
RosterEditPage::verifyRosterEditPageIntact($I);
RosterEditPage::verifyInitialValuesPresent($I);
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


$I->amGoingTo("Start deleting the student in the second row but cancel the operation");
    $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);
    //click delete button
    $I->click('//*[@id="deleteStudentButton2"]');
    $I->wait(2);
    //see warning modal
    $I->see(RosterEditPage::$deleteStudentWarningModalText);
    //click cancel
    $I->click('.cancelButton');
    //modal goes away
    $I->wait(1);
    //see warning modal
    $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);
    //check still present
    $I->seeInField("form input[type=text]", 'lastNameOfExisting2');
    $I->seeInField("form input[type=text]", 'firstNameOfExisting2');
    $I->seeInField("form input[type=text]", 'student2@email.com');


$I->amGoingTo("Delete the student in the second row");
    $I->click('//*[@id="deleteStudentButton2"]');
    $I->wait(2);
    //see warning modal
    $I->see(RosterEditPage::$deleteStudentWarningModalText);
    //click confirm button
    $I->click('.deleteConfirmButton');
    //modal goes away
    $I->wait(1);
    $I->dontSee(RosterEditPage::$deleteStudentWarningModalText);
    //check gone
    $I->dontSeeInField("form input[type=text]", 'lastNameOfExisting2');
    $I->dontSeeInField("form input[type=text]", 'firstNameOfExisting2');
    $I->dontSeeInField("form input[type=text]", 'student2@email.com');


$I->amGoingTo("Edit properties of the student in the third row");
    $I->fillField('//*[@id="lastName3"]', $editedStudentLastName);
    $I->fillField('//*[@id="firstName3"]', $editedStudentFirstName);
    $I->fillField('//*[@id="studentIdentifier3"]', ''); //replace existing w empty string
    $I->fillField('//*[@id="email3"]', $editedStudentEmail); //replace empty with string


$I->amGoingTo("Add a student");
    //make sure empty row absent
    $I->dontSeeElement("#lastName{$newRowIdx}");
    $I->dontSeeElement("#firstName{$newRowIdx}");
    $I->dontSeeElement("#studentIdentifier{$newRowIdx}");
    $I->dontSeeElement("#email{$newRowIdx}");
    //click the button to add row
    $I->click(RosterEditPage::$addStudentButton);
    //confirm that see row
    $I->seeElement("#lastName{$newRowIdx}");
    $I->seeElement("#firstName{$newRowIdx}");
    $I->seeElement("#studentIdentifier{$newRowIdx}");
    $I->seeElement("#email{$newRowIdx}");
    //fill row
    $I->fillField("//*[@id='lastName{$newRowIdx}']", $newStudentLastName);
    $I->fillField("//*[@id='firstName{$newRowIdx}']", $newStudentFirstName);
    $I->fillField("//*[@id='studentIdentifier{$newRowIdx}']", $newStudentSid);
    $I->fillField("//*[@id='email{$newRowIdx}']", $newStudentEmail);
    //submit the form  
    $I->click(RosterEditPage::$forwardNavButton);
    # Properly redirected
    $I->seeInTitle('Edit Exam | gradeomatic');
    $I->seeInCurrentUrl("/exam/{$examId}/edit");
    //$I->seeInCurrentUrl("/exam/{$examId}/question/1/element/edit");


$I->amGoingTo("Check that the deleted student has been removed from the db");
    $I->dontSeeInDatabase('students',
                          [
                              'user_id'    => 1,
                              'last_name'  => 'lastNameOfExisting2',
                              'first_name' => 'firstNameOfExisting2',
                              'email'      => 'student2@email.com',
                          ]);


$I->amGoingTo("Check that the edited student is in the db");
    $I->seeInDatabase('students', [
        'user_id'    => 1,
        'last_name'  => $editedStudentLastName,
        'first_name' => $editedStudentFirstName,
        'email'      => $editedStudentEmail,
    ]);


$I->amGoingTo("Check that the new student is in the db");
    $I->seeInDatabase('students', [
        'user_id'            => 1,
        'last_name'          => $newStudentLastName,
        'first_name'         => $newStudentFirstName,
        'student_identifier' => $newStudentSid,
        'email'              => $newStudentEmail,
    ]);


$I->amGoingTo("Check that the unchanged students are still in the db");
    $I->seeInDatabase('students', [
        'user_id'    => 1,
        'last_name'  => 'lastNameOfExisting1',
        'first_name' => 'firstNameOfExisting1',
    ]);
    //student 2 was deleted
    //student 3 had all values changed. empty string replaced sid
    $I->seeInDatabase('students', [
        'user_id'            => 1,
        'last_name'          => 'lastNameOfExisting4',
        'first_name'         => 'firstNameOfExisting4',
        'student_identifier' => '444444444',
        'email'              => 'student4@email.com',
    ]);
    $I->seeInDatabase('students', [
        'user_id'            => 1,
        'last_name'          => 'lastNameOfExisting5',
        'first_name'         => 'firstNameOfExisting5',
        'student_identifier' => '555555555',
        'email'              => 'student5@email.com',
    ]);
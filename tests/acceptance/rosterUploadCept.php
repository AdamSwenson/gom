<?php

use Page\RosterEditPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('upload a csv file full of students and see the students in the database');
//Log in
$I->test_login($I);
#Exam with no questions is exam #4
$examId = $I->examIdNoQuestions();
# Go to page
$I->amOnPage("/exam/{$examId}/student/edit");
$I->wait(2);
RosterEditPage::verifyRosterEditPageIntact($I);
RosterEditPage::verifyInitialValuesPresent($I);

//$I->amGoingTo("Check that the page is in its initial state and everything is displayed as expected");
//    # Make sure seeing what should
//    $I->seeInTitle(RosterEditPage::$pageTitleText);
//    //correct navs
//    $I->seeElement(RosterEditPage::$forwardNavButton);
//    $I->see(RosterEditPage::$forwardNavText, RosterEditPage::$forwardNavXPath);
//    $I->seeElement(RosterEditPage::$backNavButton);
//    $I->see(RosterEditPage::$backNavText, RosterEditPage::$backNavXPath);


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
//    $s = RosterEditPage::students1Through5();
//    foreach( $s as $v){
//            $I->seeInField("form input[type=text]", $v['last']);
//            $I->seeInField("form input[type=text]", $v['first']);
//            if(! is_null($v['sid'])){
//                $I->seeInField("form input[type=text]", $v['sid']);
//            }
//            if(! is_null($v['email'])){
//                $I->seeInField("form input[type=text]", $v['email']);
//            }
//        }


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
    $I->seeInCurrentUrl("exam/{$examId}/edit");
//$I->see('5 students added');


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


$I->amGoingTo("Check that we will get the default redirection experience if the exam has questions");
$examId2 = 1;

# Go to page
$I->amOnPage("/exam/{$examId2}/student/edit");
$I->wait(2);
RosterEditPage::verifyRosterEditPageIntact($I);
RosterEditPage::verifyInitialValuesPresent($I);
//# Make sure seeing what should
//$I->seeInTitle('Edit Roster | gradeomatic');
////correct navs
//$I->seeElement("#forwardNavButton");
////$I->seeLink("Edit Exam");
//$I->seeElement("#backNavButton");
////$I->seeLink(" Save & Finish");

//Submit file
$I->attachFile('#fileInput', 'acceptance_test_roster.csv');
$I->click("#backNavButton");

$I->seeInTitle("Edit Elements | gradeomatic");
//since we don't need to know which question id is involved, we split this
//between two lines
//the actual url would be http://localhost:8000/exam/3/question/15/element/edit
$I->seeInCurrentUrl("/exam/{$examId2}/question");
$I->seeInCurrentUrl("/element/edit");




//success message

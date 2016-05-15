<?php
use Page\RosterEditPage;

$students = RosterEditPage::students1Through5();

$scenario->group('roster');
$I = new AcceptanceTester($scenario);
$I->wantTo("Delete a roster and see that all students on it were removed from all tables");
//Log in
$I->test_login($I);
$I->wait(2);

#Exam with questions is exam #1
$examId = $I->examIdWithQuestions();
# Go to page
$I->amOnPage("/exam/{$examId}/student/edit");
$I->wait(2);

RosterEditPage::verifyRosterEditPageIntact($I);
RosterEditPage::verifyInitialValuesPresent($I);
//$I->amGoingTo("Check that the page is in its initial state and everything is displayed as expected");
//    $I->seeInTitle(RosterEditPage::$pageTitleText);
//    //correct navs
//    $I->seeElement(RosterEditPage::$forwardNavButton);
//    $I->see(RosterEditPage::$forwardNavText, RosterEditPage::$forwardNavXPath);
//    $I->seeElement(RosterEditPage::$backNavButton);
//    $I->see(RosterEditPage::$backNavText, RosterEditPage::$backNavXPath);
//
//    //expected students
//    $s = RosterEditPage::students1Through5();
//    for ( $i = 1; $i <= count($s); $i++ )
//    {
//        $v = $students[ $i ];
//        $I->seeInField("form input[type=text]", $v['last']);
//        $I->seeInField("form input[type=text]", $v['first']);
//        if ( ! is_null($v['sid']) )
//        {
//            $I->seeInField("form input[type=text]", $v['sid']);
//        }
//        if ( ! is_null($v['email']) )
//        {
//            $I->seeInField("form input[type=text]", $v['email']);
//        }
//    }


$I->amGoingTo("Click the roster delete button but cancel ");
    $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
    $I->click(RosterEditPage::$deleteRosterButton);
    $I->wait(2);
    //check can see warning
    $I->see(RosterEditPage::$deleteRosterWarningModalText);
    //click cancel
    $I->click(RosterEditPage::$rosterDeleteModalCancelButton);
    $I->wait(1);
    //check modal closed
    $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
    //check rows not removed
    for ( $i = 1; $i <= 5; $i++ )
    {
        $v = $students[ $i ];
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


$I->amGoingTo("Delete the roster");
    $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
    $I->click(RosterEditPage::$deleteRosterButton);
    $I->wait(2);
    //check can see warning
    $I->see(RosterEditPage::$deleteRosterWarningModalText);
    //click confirm
    $I->click(RosterEditPage::$rosterDeleteModalConfirmButton);
    $I->wait(2);
    //check modal closed
    $I->dontSee(RosterEditPage::$deleteRosterWarningModalText);
    //post delete message

    $I->see(RosterEditPage::$postDeleteMessage);
//    $I->click('/html/body/div[3]/div/div/div[2]/button');
$I->click(RosterEditPage::$postDeleteMessageCloseButton);
//RosterEditPage::$postDeleteMessageCloseButton);
$I->wait(2);
    $I->dontSee(RosterEditPage::$postDeleteMessage);
    //check rows were removed
    $I->dontSeeElement('//*[@id="studentRosterBody"]/tr');
    for ( $i = 1; $i <= 5; $i++ )
    {
        $v = $students[ $i ];
        $I->dontSee($v['last']);
        $I->dontSee($v['first']);
        if ( ! is_null($v['sid']) )
        {
            $I->dontSee( $v['sid']);
        }
        if ( ! is_null($v['email']) )
        {
            $I->dontSee($v['email']);
        }
    }




$I->amGoingTo("Submit the form");
    $I->click(RosterEditPage::$forwardNavButton);

$I->amGoingTo("Verify that I was properly redirected");
    $I->seeInTitle("Edit Exam | gradeomatic");
    $I->seeInCurrentUrl("exam/{$examId}/edit");

//TODO Do I want to check other tables to make sure the removal cascaded?
$I->amGoingTo("Check that all the students were removed from the database");
for ( $i = 1; $i <= 5; $i++ )
{
    $v = $students[ $i ];
    $record = [
        'user_id'    => 1,
        'last_name'  => $v['last'],
        'first_name' => $v['first']
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


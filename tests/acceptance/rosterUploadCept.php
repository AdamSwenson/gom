<?php

$examId = 1;

$I = new AcceptanceTester($scenario);
$I->wantTo('upload a csv file full of students and see the students in the database');

//Log in
$I->test_login($I);

//Go to page
$I->amOnPage('/exam/1/student/edit');

$I->wait(10);

//Make sure seeing what should
$I->seeInTitle('Edit Roster | gradeomatic');

$I->attachFile('#fileInput', 'acceptance_test_roster.csv');


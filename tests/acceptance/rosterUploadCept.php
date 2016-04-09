<?php

$examId = 1;

$I = new AcceptanceTester($scenario);
$I->wantTo('upload a csv file full of students and see the students in the database');


$I->test_login($I);


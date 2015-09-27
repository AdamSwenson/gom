<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('click past the question edit page and have nothing change');

\Illuminate\Support\Facades\Auth::loginUsingId(1);
$I->disableMiddleware();

$I->amOnPage('/exam');

//$I->seeInTitle("Exam Setup | gradeomatic");


$I->amOnPage('/exam/1/question/edit');


$I->seeInTitle("Edit Questions | gradeomatic");

$I->see("Add / Edit Questions");
$I->see("Add / Edit Elements");

$I->click("Add / Edit Elements");

$I->canSeeResponseCodeIs(200);
//$I->click('#next');
//$I->click('Add / Edit Elements <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>');
//$I->click(['css' => 'a.glyphicon.glyphicon-chevron-right']);
//$I->submitForm('#questionForm', []);
//$I->executeJS("jQuery('#questionForm').submit()");
//$I->executeJS("submitForm('editElements');");
//$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 1, 'question_number' => 1]);
//$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 2, 'question_number' => 2]);
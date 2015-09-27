<?php 
$I = new FunctionalTester($scenario);

$I->wantTo('click past the question edit page and have nothing change');

\Illuminate\Support\Facades\Auth::loginUsingId(1);

$I->disableMiddleware();

/* --------------------------------------- Open the page */
$I->amOnPage('/exam/1/question/edit');

/* --------------------------------------- Check that opened correctly */
$I->seeInTitle("Edit Questions | gradeomatic");
//See page description
$I->see("Add / Edit Questions");
//Make sure see nav button
$I->see("Add / Edit Elements");

/* --------------------------------------- Submit the page */
$I->submitForm('#questionForm', []);

//Check that sent to next page
$I->canSeeResponseCodeIs(200);
$I->seeInTitle("Edit Elements | gradeomatic");

//Verify that assignments not altered
$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 1, 'question_number' => 1]);
$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 2, 'question_number' => 2]);
$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 3, 'question_number' => 3]);
$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 4, 'question_number' => 4]);
$I->seeInDatabase('question_assignments', ['exam_id' => 1, 'question_id' => 5, 'question_number' => 5]);

//Verify that question scores not deleted
$I->seeInDatabase('question_scores', ['question_assignment_id' => 1]);
$I->seeInDatabase('question_scores', ['question_assignment_id' => 2]);
$I->seeInDatabase('question_scores', ['question_assignment_id' => 3]);
$I->seeInDatabase('question_scores', ['question_assignment_id' => 4]);
$I->seeInDatabase('question_scores', ['question_assignment_id' => 5]);
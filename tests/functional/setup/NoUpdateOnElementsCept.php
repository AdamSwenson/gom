<?php 
$I = new FunctionalTester($scenario);

$I->wantTo('Click past the element edit page and have nothing in the database change ');

\Illuminate\Support\Facades\Auth::loginUsingId(1);

$I->disableMiddleware();

/* --------------------------------------- Open the page */
$I->amOnPage('/exam/1/question/1/element/edit');

/* --------------------------------------- Check that opened correctly */
$I->seeInTitle("Edit Elements | gradeomatic");
//See page description
$I->see("Add / Edit Elements");
//Make sure see nav button
$I->see("Next Question");

/* --------------------------------------- Submit the page */
$I->submitForm('#elementForm', ['nextAction' => 2]);

//Check that sent to next page
$I->canSeeResponseCodeIs(200);
$I->seeInCurrentUrl('/exam/1/question/2/element/edit');
$I->seeInTitle("Edit Elements | gradeomatic");

//Verify that assignments not altered
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 1, 'element_id' => 1, 'subtask' => 1]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 1, 'element_id' => 2, 'subtask' => 2]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 1, 'element_id' => 3, 'subtask' => 3]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 1, 'element_id' => 4, 'subtask' => 4]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 1, 'element_id' => 5, 'subtask' => 5]);

$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 2, 'element_id' => 6, 'subtask' => 1]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 2, 'element_id' => 7, 'subtask' => 2]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 2, 'element_id' => 8, 'subtask' => 3]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 2, 'element_id' => 9, 'subtask' => 4]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 2, 'element_id' => 10, 'subtask' => 5]);

$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 3, 'element_id' => 11, 'subtask' => 1]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 3, 'element_id' => 12, 'subtask' => 2]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 3, 'element_id' => 13, 'subtask' => 3]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 3, 'element_id' => 14, 'subtask' => 4]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 3, 'element_id' => 15, 'subtask' => 5]);

$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 4, 'element_id' => 16, 'subtask' => 1]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 4, 'element_id' => 17, 'subtask' => 2]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 4, 'element_id' => 18, 'subtask' => 3]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 4, 'element_id' => 19, 'subtask' => 4]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 4, 'element_id' => 20, 'subtask' => 5]);

$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 5, 'element_id' => 21, 'subtask' => 1]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 5, 'element_id' => 22, 'subtask' => 2]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 5, 'element_id' => 23, 'subtask' => 3]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 5, 'element_id' => 24, 'subtask' => 4]);
$I->seeInDatabase('element_assignments', ['exam_id' => 1, 'question_id' => 5, 'element_id' => 25, 'subtask' => 5]);


//Verify that element scores not deleted
for($i=1; $i<= 25; $i++)
{
    $I->seeInDatabase('element_scores', ['element_assignment_id' => $i]);
}
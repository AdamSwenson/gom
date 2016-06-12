<?php
use Page\report\FeedbackPage;

//@group report
//@group feedback

//$scenario->group(['report', 'feedback']);

$accessKey = "634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b";
$numQuestions = 5;
$numElements = 5;
$letterGrade = "A+";
$name = 'name1';
$identifier = 'identifier1';


$I = new AcceptanceTester($scenario);
$I->wantTo('Check that feedback page displays normally');
$I->amOnPage(FeedbackPage::routeWithAccessKeyInRequest($accessKey));
$I->wait(2);

$I->amGoingTo("check that expected student info is present");
    $I->see($accessKey, ['id' => FeedbackPage::$accessKeyId]);
    $I->see($identifier, ['id' => FeedbackPage::$studentIdentifierId]);
    $I->see($letterGrade, ['id' => FeedbackPage::$gradeId]);
    $I->see($name, ['id' => FeedbackPage::$studentNameId]);


$I->amGoingTo("Check that the headings and divs are present for each question and element");
    for($i=1; $i<=$numQuestions; $i++){
        $I->see("Q{$i}:");
        //check question divs present (from outer to inner)
        $I->seeElementInDOM(['id' => "q{$i}"]);
        $I->seeElementInDOM(['id' => "q{$i}Comments"]); //text div
        $I->seeElementInDOM(['id'=> "s{$accessKey}_q{$i}"]); //chart div

        for($k=1; $k<=$numElements; $k++){
            $I->expectTo("see a div with id q{$i}e{$k}");
            $I->seeElement(['id'=> "q{$i}e{$k}"]);
        }
    }


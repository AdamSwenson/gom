<?php
use Page\grade\GradingPage;

$examId = 2; //nothing graded
$studentRowId = 1;
$studentNumber = 1;//the number which will be in the name of the student
$numQuestions = 5;
$numElements = 5;
$maxScore = 100;

$scenario->group('grade');
$I = new AcceptanceTester($scenario);
$I->wantTo('test out the functions of the letter grade button');

$I->test_login($I);
$I->amOnPage(GradingPage::route($examId));
$I->wait(2);

$I->wantTo("Test the letter grade buttons");
$letterGrades = App\Repositories\Grade\GradeFactory::$grades;
for ( $i = 1; $i <= $numQuestions; $i++ )
{
    $I->amGoingTo("Test the letter grade button for question {$i}");
    $I->click(GradingPage::questionPanelTabXPath($i));
    $I->wait(2);

    $I->amGoingTo("check that the letter grade button for question {$i} is present");
    $I->seeElement(GradingPage::letterGradeButtonLabelXPath($i));
    $I->seeElement(GradingPage::letterGradeButtonXPath($i));
    $I->see(GradingPage::$letterGradeButtonText);

    $I->expectTo("see the list of grades once I click the button");
    $I->click(GradingPage::letterGradeButtonXPath($i));
    $I->wait(1);
    $I->seeElement(['id' => GradingPage::$letterGradeListId]);
    foreach ( $letterGrades as $g )
    {
        $I->expectTo("see the grade {$g['display_value']}");
        $I->see($g['display_value'], ['id' => GradingPage::$letterGradeListId]);
    }


    $I->amGoingTo("Click each grade button and make sure the value changes");
    $I->click(GradingPage::questionPanelTabXPath(2));
    $I->wait(2);
    $I->click(GradingPage::questionPanelTabXPath(1));
    $I->wait(2);
    $i = 1;
    foreach ( $letterGrades as $g )
    {
        //click the letter grade button
//                $I->click(GradingPage::letterGradeButtonXPath($i));
        $I->click(['css' => "#letterGradeForQuestion{$i}"]);
        $I->waitForElementVisible(['css' => '#letterGradeList']);
        //check that see the value
        $I->see($g['display_value'], ['id' => GradingPage::$letterGradeListId]);
        $I->amGoingTo("select {$g['display_value']} and see the question score updated properly");
        //click the list item
        //      $I->click("//*[@id='letterGradeList']/li[{$i}]/a");
        $I->click($g['display_value'], ['id' => GradingPage::$letterGradeListId]);
        $I->wait(2);
        $expectedScore = intval($maxScore * (.01 * $g['calc_value']));
        $I->expectTo("see the question score {$expectedScore}");
        $I->seeInField(GradingPage::questionScoreFieldXPath($i), $expectedScore);
        //todo add check that see tooltip
        //*[@id="letterGradeList"]/li[2]/a
        //*[@id="letterGradeList"]/li[1]/a

        //        $I->amGoingTo("navigate to another question then come back to see if has same value");
        //        $otherTab = $i == $numQuestions ? 1 : $i + 1;
        //        $I->click(GradingPage::questionPanelTabXPath($otherTab));
        //        $I->wait(3);
        //        $I->click(GradingPage::questionPanelTabXPath($i));
        //        $I->seeInField(GradingPage::questionScoreFieldXPath($i), $expectedScore);

        //click the letter grade button
        $I->click(GradingPage::letterGradeButtonXPath($i));
        $I->wait(2);
        foreach ( $letterGrades as $g )
        {
            $I->expectTo("see the grade {$g['display_value']}");
            $I->see($g['display_value'], GradingPage::$letterGradeButtonContainerXPath);
        }
    }


}


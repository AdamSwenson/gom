<?php
use Page\grade\GradingPage;

$examId = 2; //nothing graded
$studentRowId = 1;
$studentNumber = 1;//the number which will be in the name of the student
$numQuestions = 5;
$numElements = 5;
$maxScore = 100;

$I = new AcceptanceTester($scenario);
$I->wantTo('Check the grading page to make sure everything works properly');

$I->test_login($I);
$I->amOnPage(GradingPage::route($examId));
$I->wait(2);
  
GradingPage::verifyGradingPageIntact($I, $examId);


$I->amGoingTo("Click the student row {$studentRowId} and check that see everything expected (except for dashboard related changes, which are checked elsewhere)");
$I->dontSeeElement(['id' => 'questionPanel']);
GradingPage::clickStudentRow($I, $studentRowId);

$I->expectTo("see the selected student's name in the active student field");
$I->seeInField(GradingPage::$activeStudentNameFieldXPath, "lastNameOfExisting{$studentNumber}, firstNameOfExisting{$studentNumber}");

$I->expectTo("see that the question fields have displayed");
$I->see('Question #1: "Exam' . $examId . 'Question1"');
for ( $i = 1; $i <= $numQuestions; $i++ )
{
    //check that see tabs
    $I->see("Q{$i}");
    $I->seeElement(GradingPage::questionPanelTabXPath($i));
}

$I->amGoingTo("Click the question tabs and check that expected things display");
for ( $i = 1; $i <= $numQuestions; $i++ )
{
    $I->click(GradingPage::questionPanelTabXPath($i));
    $I->wait(2);

    $I->amGoingTo("check that the letter grade button and question score field are present");
    $I->seeElement(GradingPage::letterGradeButtonLabelXPath($i));
    $I->seeElement(GradingPage::letterGradeButtonXPath($i));
    $I->see(GradingPage::$letterGradeButtonText);
    $I->seeElement(GradingPage::questionScoreFieldXPath($i));


    $I->amGoingTo("Check that the elements for question {$i} are displaying");
    for ( $j = 1; $j <= $numElements; $j++ )
    {
        $I->seeElement(GradingPage::elementAreaXPath($i, $j));
        //check that elements are displayed
        $I->see("Element #{$j}: ");
        //todo expected element name full text


        $I->amGoingTo("Inspect the comment area for Q{$i}E{$j}");
        $I->seeElement(GradingPage::commentXPath($i, $j));

    }
    /*
       for($j=1; $j<=$numElements; $j++)
       {
           //TODO this seems to get hosed because of an error in the slider library around line 15410
           $I->amGoingTo("Inspect the slider parts for Q{$i}E{$j}");
           //the original input will be hidden so can't just look for element
           $I->expect("The original input will be hidden and replaced with the bootstrap slider");
           //  $I->dontSeeElement(GradingPage::sliderXPath($i, $j));
           $I->seeElementInDOM(GradingPage::sliderXPath($i, $j));

           $I->expect("The valence labels will be visible. ");
           foreach ( GradingPage::$sliderValenceLabels as $v )
           {
               //$I->see($v); //, "#Q{$i}E{$j}");
               $I->see($v, GradingPage::elementAreaXPath($i, $j));
           }
       }
    */
}


//move sliders

//edit comment

//letter grade button
$I->amGoingTo("Test the letter grade buttons");
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
            $I->click(GradingPage::letterGradeButtonXPath($i));
            $I->wait(1);
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


//switch student

//switch back to first student

//test typeahead
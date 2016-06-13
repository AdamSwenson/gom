<?php

use Page\grade\GradingPage;

class SliderAndCommentsCest
{
    public $examId = 2; //nothing graded
    public $studentRowId = 1;
    public $studentNumber = 2;//the number which will be in the name of the student
    public $numStudents = 5;
    public $numQuestions = 5;
    public $numElements = 5;
    public $maxScore = 100;

    public $questionNumber = 1;

    public $makeWritable = " $( '[name^=\"commentQ\"]' ).prop( 'readonly', '' );";

    public function _before(AcceptanceTester $I)
    {
        GradingPage::navigateToGradingPage($I, $this->examId);
        GradingPage::clickStudentRow($I, $this->studentRowId);
        GradingPage::clickQuestionTab($I, $this->questionNumber);
//$I->wait(45);
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group comments
     */
    public function editComment(AcceptanceTester $I){
        $newText = Faker\Factory::create()->text();
        $I->executeJS($this->makeWritable);
        $I->wait(5);

        $I->amGoingTo("add text to the field");
        $I->fillField(GradingPage::commentFieldLocator(1, 1), $newText);

        $I->amGoingTo('click away to another question');
        GradingPage::clickQuestionTab($I, $this->questionNumber + 1);
        $I->dontSeeElement(GradingPage::commentFieldLocator(1,1));

        $I->amGoingTo("come back");
        GradingPage::clickQuestionTab($I, $this->questionNumber);
        $I->seeElement(GradingPage::commentFieldLocator(1,1));

        $I->expectTo("see the new text present");
        $I->seeInField(GradingPage::commentFieldLocator(1, 1), $newText);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group comments
     */
    public function switchStudentAndCommentChange(AcceptanceTester $I, $scenario){
        $scenario->incomplete();
        $newText = Faker\Factory::create()->text();
        $I->executeJS($this->makeWritable);
        $I->wait(2);

        $I->amGoingTo("add text to the field");
        $I->fillField(GradingPage::commentFieldLocator(1, 1), $newText);
        $I->seeInField(GradingPage::commentFieldLocator(1,1), $newText);

        $I->amGoingTo("select another student to ensure that new text doesn't carry over to different student");
        $newId = $this->studentRowId + 1;
        GradingPage::clickStudentRow($I, $newId);
        $I->wait(4);
        GradingPage::clickQuestionTab($I, $this->questionNumber);
        $I->wait(2);
        $I->expectTo("see the comment field");
        $I->seeElement(GradingPage::commentFieldLocator(1, 1));

        $I->expect("to not see the new text entered for the original student");
        $I->dontSeeInField(GradingPage::commentFieldLocator(1,1), $newText);

        $I->amGoingTo("go back to the first student");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        GradingPage::clickQuestionTab($I, $this->questionNumber);

        $I->expectTo("see the comment field");
        $I->seeElement(GradingPage::commentFieldLocator(1, 1));
        $I->expectTo("see the new text");
        $I->seeInField(GradingPage::commentFieldLocator(1,1), $newText);
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     */
    public function checkBehavior(AcceptanceTester $I, $scenario){
        $scenario->incomplete();
        $r = $I->executeJS( "$('#Qs1').trigger('slideStop');" );
        codecept_debug($r);
        $handle = ['css' => "#element1 > div > span.col-lg-5.sliderContainer.Q1E1 > div > div.slider-track > div.slider-tick.round.in-selection"];
        $I->seeElement($handle);

        $rightPole = ['css' => "#element1 > div > span.col-lg-5.sliderContainer.Q1E1 > div > div.slider-track > div:nth-child(7)"];
        $I->seeElement($rightPole);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     */
    public function moveSliders(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
        $I->wantTo('Manipulate the sliders and comment area and see the expected changes');
$I->wait(5);
        $I->expectTo("see the slider elements on the page");
        $handle = ['css' => "html body div.container-fluid div.row div#questionAndSliderColumn.col-md-8.questionAndSliderColumn div#questionArea.startHidden div#questionPanel.panel.panel-default.questionPanel div.panel-body div.tab-content div#panelQuestion1.tab-pane.fadein.active div.list-group div#element1.list-group-item.elementPanel div.row span.col-lg-5.sliderContainer.Q1E1 div#Qs1.slider.slider-horizontal div.slider-track div.slider-handle.max-slider-handle"];
//        $handle = ['css' => "#element1 > div > span.col-lg-5.sliderContainer.Q1E1 > div > div.slider-track > div.slider-tick.round.in-selection"];
        //$rightPole = ['css' => "#element1 > div > span.col-lg-5.sliderContainer.Q1E1 > div > div.slider-track > div:nth-child(7)"];
        $rightPole = ['css' => "#Qs2 > div.slider-track > div:nth-child(7)"];
        $d = $I->seeElement($handle);
        codecept_debug($d);
//        $I->seeElement($rightPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
$I->wait(3);
        $I->seeElement(['id' => "commentQ1E1"]);
        $I->see("comment104BodyText", ['id' => "commentQ1E1"]);
    }



//move sliders

//move slider: same valence

//move slider: different valence

//edit comment

//edited comment changes
}
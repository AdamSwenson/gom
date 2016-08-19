<?php

use Faker\Factory;
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
     * @group elementInput
     * @group comments
     */
    public function initialState(AcceptanceTester $I)
    {
        $I->expect('the comments field to be blank');
        for ( $i = 1; $i <= $this->numElements; $i++ )
        {
            $I->seeInField(GradingPage::commentFieldLocator($this->questionNumber, $i), '');
        }
    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group elementInput
     * @group comments
     */
    public function editComment(AcceptanceTester $I)
    {
        $newText = Faker\Factory::create()->text();
        $I->executeJS($this->makeWritable);
        $I->wait(1);

        $I->amGoingTo("add text to the field");
        $I->fillField(GradingPage::commentFieldLocator(1, 1), $newText);

        $I->amGoingTo('click away to another question');
        GradingPage::clickQuestionTab($I, $this->questionNumber + 1);
        $I->dontSeeElement(GradingPage::commentFieldLocator(1, 1));

        $I->amGoingTo("come back");
        GradingPage::clickQuestionTab($I, $this->questionNumber);
        $I->seeElement(GradingPage::commentFieldLocator(1, 1));

        $I->expectTo("see the new text present");
        $I->seeInField(GradingPage::commentFieldLocator(1, 1), $newText);

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group elementInput
     * @group comments
     */
    public function switchStudentAndCommentChange(AcceptanceTester $I)
    {

        $newText = Faker\Factory::create()->text();
        $I->executeJS($this->makeWritable);
        $I->wait(1);

        $I->amGoingTo("add text to the field");
        $I->fillField(GradingPage::commentFieldLocator(1, 1), $newText);
        $I->seeInField(GradingPage::commentFieldLocator(1, 1), $newText);

        $I->amGoingTo("select another student to ensure that new text doesn't carry over to different student");
        $newId = $this->studentRowId + 1;
        GradingPage::clickStudentRow($I, $newId);
        $I->wait(1);
        GradingPage::clickQuestionTab($I, $this->questionNumber);
        $I->wait(1);
        $I->expectTo("see the comment field");
        $I->seeElement(GradingPage::commentFieldLocator(1, 1));

        $I->expect("to not see the new text entered for the original student");
        $I->dontSeeInField(GradingPage::commentFieldLocator(1, 1), $newText);

        $I->amGoingTo("go back to the first student");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        GradingPage::clickQuestionTab($I, $this->questionNumber);

        $I->expectTo("see the comment field");
        $I->seeElement(GradingPage::commentFieldLocator(1, 1));
        $I->expectTo("see the new text");
        $I->seeInField(GradingPage::commentFieldLocator(1, 1), $newText);
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group elementInput
     * @group sliders
     *
     */
    public function seeSliders(AcceptanceTester $I)
    {
        $I->expectTo('See the slider elements for q1e1');
        $r = $I->executeJS("$('#Qs1').trigger('slideStop');");
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
     * @group elementInput
     *
     */
    public function moveSliders(AcceptanceTester $I)
    {
        $I->wantTo('Manipulate the sliders and comment area and see the expected changes');

        $questionNumber = 1;
        $elementNumber = 1;

        $I->expectTo("see the slider elements on the page");


        $handle = GradingPage::sliderHandleLocator($questionNumber, $elementNumber);
        $I->seeElement($handle);
        $rightPole = GradingPage::sliderRightPoleLocator($questionNumber, $elementNumber);
        $I->seeElement($rightPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
        $I->wait(1);
        $I->seeElement(['id' => "commentQ1E1"]);
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     *
     */
    public function moveSliderSameValence(AcceptanceTester $I)
    {
        $I->wantTo("change the value of the slider within the same valence, and see the same comment");

    }

    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     *
     */
    public function moveSliderNewValence(AcceptanceTester $I)
    {
        $I->wantTo("change the value of the slider outside the same valence, and see a new comment");

        $elementNumber = 1;
        $handle = GradingPage::sliderHandleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($handle);
        $rightPole = GradingPage::sliderRightPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($rightPole);
        $leftPole = GradingPage::sliderTrackPositionLocator($this->questionNumber, $elementNumber, 5);
        $I->seeElement($leftPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
        $I->wait(1);

        $I->expectTo("see the corresponding comment");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");

        //call
        $I->amGoingTo("drag the slider to the left stopping at poor ");
        $I->dragAndDrop($handle, $leftPole);
        $I->wait(1);
        $I->expectTo("see the comment for poor ");
        $I->seeInField(['id' => "commentQ1E1"], "comment102BodyText");
    }

//move slider: different valence

//edit comment
    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     * @group bugFixes
     * This elicits a bug where moving the slider to missing clears the custom comment.
     */
    public function moveSliderEditComment(AcceptanceTester $I)
    {
        $I->wantTo("edit a preset comment and then see that it is not changed by further moves of the slider.");
        //prp

        $elementNumber = 1;
        $handle = GradingPage::sliderHandleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($handle);
        $rightPole = GradingPage::sliderRightPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($rightPole);
        $leftPole = GradingPage::sliderLeftPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($leftPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
        $I->wait(1);

        $I->expectTo("see the corresponding comment");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");

        //call
        $I->amGoingTo("edit the comment field");
        $text = Factory::create()->text;
        $I->fillField(['id' => "commentQ1E1"], $text);
        $I->executeJS("$('#commentQ1E1').trigger('change')");
//        $I->executeJS(document.getElementById('commentQ1E1'))

        $I->wait(1);
        $I->seeInField(['id' => "commentQ1E1"], $text);

        $I->amGoingTo("drag the slider all the way to the left");
        $I->dragAndDrop($handle, $leftPole);
        $I->wait(1);
        $I->expectTo("still see my edited text");
        $I->seeInField(['id' => "commentQ1E1"], $text);
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     *
     */
    public function updateEditedComment(AcceptanceTester $I)
    {
        $I->wantTo("update a edited comment and see that it is not changed by further moves of the slider.");
    }

    //same element different students
    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     * @group bugFixes
     */
    public function changeStudents(AcceptanceTester $I)
    {
        $I->wantTo("record a score and comment with the slider, then change students and make sure that the comment and score are still present when come back.");
        $elementNumber = 1;
        $handle = GradingPage::sliderHandleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($handle);
        $rightPole = GradingPage::sliderRightPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($rightPole);
        $leftPole = GradingPage::sliderLeftPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($leftPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
        $I->wait(1);

        $I->expectTo("see the expected comment");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");

        $I->amGoingTo('change students');
        GradingPage::clickStudentRow($I, $this->studentRowId + 1);
        GradingPage::clickQuestionTab($I, $this->questionNumber);

        $I->expectTo("see a blank comment field");
        $I->seeInField(['id' => "commentQ1E1"], "");

        $I->amGoingTo("switch back to the first student");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        GradingPage::clickQuestionTab($I, $this->questionNumber);

        $I->expectTo("see the comment recorded earlier");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     * @group bugFixes
     * This should reveal  a possible bug found in 62ae01f0
     */
    public function changeQuestions(AcceptanceTester $I)
    {
        //
        $I->wantTo("record a score and comment with the slider, then change questions and make sure that the comment and score are still present when come back.");

        $elementNumber = 1;
        $handle = GradingPage::sliderHandleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($handle);
        $rightPole = GradingPage::sliderRightPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($rightPole);
        $leftPole = GradingPage::sliderLeftPoleLocator($this->questionNumber, $elementNumber);
        $I->seeElement($leftPole);

        $I->amGoingTo("drag the slider all the way to the right");
        $I->dragAndDrop($handle, $rightPole);
        $I->wait(1);

        $I->expectTo("see the expected comment");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");

        $I->amGoingTo('change questions');
        GradingPage::clickQuestionTab($I, $this->questionNumber + 1);

        $I->expectTo("see a blank comment field");
        $I->seeInField(['id' => "commentQ2E1"], "");

        $I->amGoingTo("switch back to the first question");
        GradingPage::clickQuestionTab($I, $this->questionNumber);

        $I->expectTo("see the comment recorded earlier");
        $I->seeInField(['id' => "commentQ1E1"], "comment104BodyText");
        $I->expectTo("see the expected comment");
    }


    /**
     * @param AcceptanceTester $I
     * @group grade
     * @group sliders
     * @group elementInput
     * @group bugFixes
     * This should reveal  a possible bug found in 62ae01f0
     */
    public function movingSliderToMissingDoesNotClearCustomComment(AcceptanceTester $I){

    }

}
<?php
use Page\grade\GradingPage;
use Page\grade\LetterGradeButtonArea;

/**
 *
 * @group('grade')
 */
class LetterGradeButtonCest
{

    public $examId = 2; //nothing graded

    public $studentRowId = 1;

    public $studentNumber = 1;//the number which will be in the name of the student
    public $numQuestions = 5;
    public $numElements = 5;
    public $maxScore = 100;

    public $letterGrades = [];

    public function _before(AcceptanceTester $I)
    {
        $this->letterGrades = App\Repositories\Grade\GradeFactory::$grades;

        GradingPage::navigateToGradingPage($I, $this->examId);
        GradingPage::clickStudentRow($I, 0);
        $I->wait(1);
        LetterGradeButtonArea::assertLetterGradeButtonVisible($I, 1);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function clickLetterGradeButton(AcceptanceTester $I)
    {
        $I->wantTo("Test the letter grade buttons");
        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            $I->amGoingTo("Test the letter grade button for question {$i}");
            GradingPage::clickQuestionTab($I, $i);
            LetterGradeButtonArea::assertClickingLetterGradeButtonRevealsGradeList($I, $i, $this->letterGrades);
        }
    }

    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function clickGradeButtons(AcceptanceTester $I)
    {
        $questionNumber = 2;
        $I->amGoingTo("Click each grade button and make sure the question score changes");
        GradingPage::clickQuestionTab($I, $questionNumber);

        $i = 1;
        foreach ( $this->letterGrades as $g )
        {
            //click the letter grade button
            $I->click(LetterGradeButtonArea::letterGradeButtonLocator($questionNumber));

            //check that see the value
            $I->see($g['display_value'], LetterGradeButtonArea::$letterGradeListLocator);
            $I->amGoingTo("select {$g['display_value']} and see the question score updated properly");

            //click the list item
            $I->seeElement(["css" => "#letterGradeList > li:nth-child({$i}) > a"]);
            $I->click(['css' => "a.q{$questionNumber}g{$g['calc_value']}"]);
            $I->wait(1);

            $expectedScore = intval($this->maxScore * (.01 * $g['calc_value']));
            $I->expectTo("see the question score {$expectedScore}");
            $I->seeInField(GradingPage::questionScoreFieldLocator($questionNumber), $expectedScore);

            $i++;

            //todo add check that see tooltip
            //*[@id="letterGradeList"]/li[2]/a
            //*[@id="letterGradeList"]/li[1]/a

        }
    }

}


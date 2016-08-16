<?php
use Faker\Factory;
use Page\grade\GradingPage;
use Page\grade\RosterArea;


class QuestionScoreCest
{
    public $numQuestions = 5;
    public $examId = 1;
public $testStudent = 0;
public $testQuestion = 1;

    public function _before(AcceptanceTester $I)
    {
        GradingPage::navigateToGradingPage($I, $this->examId);
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     */
    public function intact(AcceptanceTester $I)
    {
        $I->wantTo("check that the question score area is intact");
        //start at q2 because q1 is currently displayed
        for ( $i = 2; $i <= $this->numQuestions; $i++ )
        {
            GradingPage::clickQuestionTab($I, $i);
            $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($i));
            $I->seeElement(GradingPage::questionScoreFieldLocator($i));
        }
    }

    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     */
    public function newScoreForQuestion(AcceptanceTester $I)
    {
        $I->wantTo("assign a score to a previously ungraded student/question");
        $testScore = Faker\Factory::create()->numberBetween(0,100);

        $I->amGoingTo("type the score into the box");
        $I->fillField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("view another student");
        $otherStudent = $this->testStudent + 2;
        GradingPage::clickStudentRow($I, $otherStudent);
        $I->wait(2);
        GradingPage::clickQuestionTab($I, 3);

        $I->expect("to not see the score I entered");
        $I->wait(1);
        GradingPage::clickQuestionTab($I, $this->testQuestion);
//        $I->dontSeeInField(GradingPage::questionScoreFieldLocator(3), $testScore);
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->amGoingTo("go back to the student I entered the grade for");
        $I->expectTo("see the score I had typed");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("reload the page to see that the new score was saved to the db");
        $I->reloadPage();
        $I->waitForElementVisible(GradingPage::$mainBodyLocator);
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->expectTo("see the score I had entered");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);
    }


    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     */
    public function deleteScoreForQuestion(AcceptanceTester $I)
    {
        $I->wantTo("delete a previously assigned score ");
        $testScore = Factory::create()->numberBetween(0,100);

        $I->amGoingTo("type the score into the box");
        $I->fillField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("view another student");
        GradingPage::clickStudentRow($I, $this->testStudent + 1);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->amGoingTo("go back to the student I entered the grade for");
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->expectTo("see the score I had typed");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("empty the question score field");
        $I->fillField(GradingPage::questionScoreFieldLocator($this->testQuestion), '');
        GradingPage::clickQuestionTab($I, $this->testQuestion + 1);

        $I->amGoingTo("reload the page to see that the empty score was saved to the db");
        $I->reloadPage();
        $I->waitForElementVisible(GradingPage::$mainBodyLocator);
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->expectTo("see no score");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), '');

    }
}

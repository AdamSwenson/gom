<?php
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
        $testScore = 55;


        $I->amGoingTo("type the score into the box");
        $I->fillField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("view another student");
        GradingPage::clickStudentRow($I, $this->testStudent + 1);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->expect("to not see the score I entered");
        $I->dontSeeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->amGoingTo("go back to the student I entered the grade for");
        $I->expectTo("see the score I had typed");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);

        $I->amGoingTo("reload the page to see that the new score was saved to the db");
        $I->reloadPage();
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));
        GradingPage::clickStudentRow($I, $this->testStudent);
        $I->waitForElementVisible(GradingPage::questionScoreFieldLocator($this->testQuestion));

        $I->expectTo("see the score I had entered");
        $I->seeInField(GradingPage::questionScoreFieldLocator($this->testQuestion), $testScore);
    }


    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     * @incomplete
     */
    public function updateScoreForQuestion(AcceptanceTester $I)
    {
        $I->wantTo("change a score and see that updated");
    }


    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     * @incomplete
     */
    public function changeStudentAndReturn(AcceptanceTester $I)
    {
        $I->wantTo("check that the score is stored when I return after grading a different student");
    }


    /**
     * @group grade
     * @group questionScore
     * @param AcceptanceTester $I
     * @incomplete
     */
    public function deleteScoreForQuestion(AcceptanceTester $I)
    {
        $I->wantTo("delete a question score and see that it has been deleted");
    }
}

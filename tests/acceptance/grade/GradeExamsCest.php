<?php
use Page\grade\GradingPage;


use Page\grade\DashboardArea;


/**
 * @group('grade')
 */
class GradeExamsCest
{
    public $examId = 2; //nothing graded
    public $studentRowId = 1;
    public $studentNumber = 2;//the number which will be in the name of the student
    public $numQuestions = 5;
    public $numElements = 5;
    public $maxScore = 100;

    public function _before(AcceptanceTester $I)
    {
        GradingPage::navigateToGradingPage($I, $this->examId);

    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function checkGradingPageComponents(AcceptanceTester $I)
    {
        $I->wantTo('Check the grading page to make sure the everything is in its place and that the large scale page changes work properly. More detailed grading operations are tested in other files');
        GradingPage::verifyGradingPageIntact($I, $this->examId);
    }

    /**
     * @group('grade')
     * @param AcceptanceTester $I
     */
    public function clickStudent(AcceptanceTester $I)
    {
        $I->wantTo("Click the student row {$this->studentRowId} and check that see everything expected (except for dashboard related changes, which are checked elsewhere)");

        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->wait(1);
        GradingPage::assertGradingPanelVisible($I);

        $I->expectTo("see the selected student's name in the active student field");
        $I->seeInField(GradingPage::$activeStudentNameFieldLocator, "lastNameOfExisting{$this->studentNumber}, firstNameOfExisting{$this->studentNumber}");

        $I->expectTo("see that the question fields have displayed");
        $I->see('Question #1: "Exam' . $this->examId . 'Question1"');
        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            $I->expectTo("see the question tab for q{$i}");
            $I->see("Q{$i}");
            $I->seeElement(GradingPage::questionPanelTabXPath($i));
        }
        
    }

    /**
     * @group grade
     * @param AcceptanceTester $I
     */
    public function checkClickQuestionTabs(AcceptanceTester $I)
    {
        $I->wantTo("Click the question tabs and check that expected things display");
        GradingPage::clickStudentRow($I, $this->studentRowId);
        $I->wait(1);

        //start at q2 because q1 is currently displayed
        for ( $i = 2; $i <= $this->numQuestions; $i++ )
        {
            GradingPage::clickQuestionTab($I, $i);
            GradingPage::assertQuestionPanelIntact($I, $i, $this->numElements);
        }

        $I->amGoingTo("go back and check question 1 (since it was showing when we started the test");
        GradingPage::clickQuestionTab($I, 1);
        GradingPage::assertQuestionPanelIntact($I, 1, $this->numElements);
    }


    /**
     * @group grade
     * @param AcceptanceTester $I
     * @incomplete
     */
    public function checkIfNoElements(AcceptanceTester $I, $scenario)
    {
        $I->wantTo("See the default message if there are no elements for a question");
        $scenario->skip();
    }


}
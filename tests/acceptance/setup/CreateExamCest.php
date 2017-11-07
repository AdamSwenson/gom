<?php

use Page\QuestionEditPage;
use Page\setup\ExamEditPage;


class CreateExamCest
{
    public $testExamName = "testExamName";


    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Inspect the list of exams on the setup page and make sure the buttons all work');
        ExamEditPage::navigateToPage($I);

    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        ExamEditPage::assertPageIntact($I);
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkTermDropdownWorking(AcceptanceTester $I)
    {
        $I->expect('that the term menu items are hidden');
        $I->dontSeeElement(['css' => '.termItem']);

        $I->amGoingTo("click the term dropdown button");
        $I->click(ExamEditPage::$termSelectLocator);

        $I->expectTo('see term menu items');
        $I->seeElement(['css' => '.termItem']);

        foreach ( ExamEditPage::$defaultTerms as $t )
        {
            $I->expectTo("see " . $t . " in the dropdown menu");
            $I->see($t);
        }

        $I->amGoingTo("select the first item on list, i.e., Winter");
        $I->click(['xpath' => '//*[@id="termList"]/li[1]/a']);

        $I->expectTo('not see term menu items');
        $I->dontSeeElement(['css' => '.termItem']);

        $I->expectTo('see the selected term but no others');
        $I->see('Winter');
        $I->dontSee('Spring');
        $I->dontSee('Summer');
        $I->dontSee('Fall');
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkYearDropdownWorking(AcceptanceTester $I)
    {
        $I->expect('that the year menu items are hidden');
        $I->dontSeeElement(['css' => '.yearItem']);

        $I->amGoingTo("click the year dropdown button");
        $I->click(ExamEditPage::$yearSelectLocator);

        $I->expectTo("see year items in the dropdown menu");
        $I->seeElement(['css' => '.yearItem']);

        $I->amGoingTo("click on the second year from the list");
        $I->click(['xpath' => '//*[@id="yearList"]/li[2]/a']);

        $I->expect('that the dropdown has closed and I no longer see year items');
        $I->dontSeeElement(['css' => '.yearItem']);

    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function createExam(AcceptanceTester $I)
    {
        $I->amGoingTo("Fill in the name field");
        $I->fillField(ExamEditPage::$examNameFieldLocator, $this->testExamName);

        $I->wantTo("Select Winter for the term");
        $I->click(ExamEditPage::$termSelectLocator);

        $I->amGoingTo("select the first item on list, i.e., Winter");
        $I->click(['xpath' => '//*[@id="termList"]/li[1]/a']);
        //grab the value for testing
        $testTerm = $I->grabTextFrom(ExamEditPage::$termSelectLocator);

        $I->amGoingTo('click the second year from the list');
        $I->click(ExamEditPage::$yearSelectLocator);
        $I->click(['xpath' => '//*[@id="yearList"]/li[2]/a']);
        //grab value for testing
        $testYear = $I->grabTextFrom('//*[@id="year"]');

        $I->amGoingTo("Submit the form");
        $I->click(ExamEditPage::$forwardNavButton);
        $I->waitForElementVisible(QuestionEditPage::$mainBodyLocator);

        $I->expectTo("have been redirected properly");
        $I->see("Add / Edit Questions");
        $I->seeInCurrentUrl('/question/edit');

        $I->expectTo("see the exam1 in the database");
        $I->assertDatabaseHas('exams', [
            'user_id'  => 1,
            'term'     => $testTerm,
            'year'     => $testYear,
            'name'     => $this->testExamName,
            'locked'   => 0,
            'released' => 0,
        ]);

    }

}
<?php

use App\Exam;
use Page\ExamCard;
use Page\ItemCard;
use Page\NewSetupPage;



class ItemCreateExamCest
{
    public $testExamName = "testExamName";


    public function _before( AcceptanceTester $I )
    {
        NewSetupPage::navigateToPage($I);
    }

    public function _after( AcceptanceTester $I )
    {
    }

    /**
     * @group item
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkIntact( AcceptanceTester $I )
    {
        NewSetupPage::assertPageIntact($I);
    ExamCard::assertCardIntact($I);
    }

    /**
     * @group item
     * @param AcceptanceTester $I
     * @return string
     */
    public function enterTextInExamName( AcceptanceTester $I )
    {
        $I->amGoingTo('Enter some text in the exam1 name box, then return to the page to make sure that it has been saved');

    }

    /**
     * @group item
     * @param AcceptanceTester $I
     * @return string
     */
    public function toggleDropdownEditingArea ( AcceptanceTester $I )
    {
        $I->wantTo('Toggle the settings menu');

        $I->amGoingTo('check that the settings area is not displayed');
        $I->dontSeeElement(ExamCard::examDetailPaneLocator());

        $I->amGoingTo('click the settings button');
        $I->seeElement(ItemCard::settingsButtonLocator(0));


        $I->amGoingTo('check that the settings area is displayed');
        $I->seeElement(ExamCard::examDetailPaneLocator());
    }


    /**
     * @group item
     * @param AcceptanceTester $I
     */
    public function addSiblingButtonsWorking( AcceptanceTester $I )
    {
        $I->wantTo('make sure that the add sibling buttons work');
    }


    /**
     * @group item
     * @param AcceptanceTester $I
     */
    public function addItemButtonWorking( AcceptanceTester $I )
    {
        $I->wantTo('make sure that the add item button works');
    }


    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkTermDropdownWorking( AcceptanceTester $I )
    {
//        $I->expect('that the term menu items are hidden');
//        $I->dontSeeElement(['css' => '.termItem']);
//
//        $I->amGoingTo("click the term dropdown button");
//        $I->click(ExamEditPage::$termSelectLocator);
//
//        $I->expectTo('see term menu items');
//        $I->seeElement(['css' => '.termItem']);
//
//        foreach ( ExamEditPage::$defaultTerms as $t ) {
//            $I->expectTo("see " . $t . " in the dropdown menu");
//            $I->see($t);
//        }
//
//        $I->amGoingTo("select the first item on list, i.e., Winter");
//        $I->click(['xpath' => '//*[@id="termList"]/li[1]/a']);
//
//        $I->expectTo('not see term menu items');
//        $I->dontSeeElement(['css' => '.termItem']);
//
//        $I->expectTo('see the selected term but no others');
//        $I->see('Winter');
//        $I->dontSee('Spring');
//        $I->dontSee('Summer');
//        $I->dontSee('Fall');
    }

    /**
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function checkYearDropdownWorking( AcceptanceTester $I )
    {
//        $I->expect('that the year menu items are hidden');
//        $I->dontSeeElement(['css' => '.yearItem']);
//
//        $I->amGoingTo("click the year dropdown button");
//        $I->click(ExamEditPage::$yearSelectLocator);
//
//        $I->expectTo("see year items in the dropdown menu");
//        $I->seeElement(['css' => '.yearItem']);
//
//        $I->amGoingTo("click on the second year from the list");
//        $I->click(['xpath' => '//*[@id="yearList"]/li[2]/a']);
//
//        $I->expect('that the dropdown has closed and I no longer see year items');
//        $I->dontSeeElement(['css' => '.yearItem']);

    }

    /**
     * @group item
     * @group setup
     * @group exam1
     * @param AcceptanceTester $I
     */
    public function createExam( AcceptanceTester $I )
    {
        $I->amGoingTo("Fill in the name field");
       #
    }

}
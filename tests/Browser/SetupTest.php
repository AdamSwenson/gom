<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/26/17
 * Time: 3:11 PM
 */

namespace Tests\Browser;

use App\Exam;
use App\User;
use Auth;
use Faker\Factory;
use Tests\Browser\Pages\SetupPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SetupTest extends DuskTestCase

{
// ------------------------------ Intact
    /**
     * @group aa
     * @group setup
     * @group editExam
     */
    public function testNavigationToPage()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible(SetupPage::$mainBodyLocator);
        });

    }

    // ----------------------------------- Editing, adding items

    /**
     * @group b
     * @group setup
     * @group exam
     * @group items
     * @group addItem
     */
    public function testAddQuestionToExam()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                //prep
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible('.add-child-to-exam-button')
                ->assertVisible('@addChildButton')
                ->assertMissing('.item-card-component')
                //call
                ->click("[id^='add-child-to-exam-button-']")
                ->waitFor('#item-card-1-0')
                ->assertVisible('.item-card-component')
                ->pause(10000);

            //make sure it persisted
            $examId = $browser->value('#examId');
            $browser->navigateToExam($examId, $user->id)
                ->waitFor(SetupPage::$mainBodyLocator)
                ->pause(5000)
                ->waitFor('#item-card-1-0')
                ->assertVisible('.item-card-component')
                ->assertVisible('#item-card-1-0');
        });

    }

    /**
     * @group aa
     * @group setup
     * @group exam
     * @group editExam
     * Alter the exam name and make sure it persists
     */
    public function testEditExamName()
    {
        $testText = Factory::create()->name;

        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user, $testText ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible('#exam-name')
                //call
                ->type('#exam-name', $testText)
                ->assertInputValue('#exam-name', $testText)
                ->pause(2000);

            //make sure it persisted
            $examId = $browser->value('#examId');
            $browser->navigateToExam($examId, $user)
                ->assertVisible('#exam-name')
                ->assertInputValue('#exam-name', $testText);
        });

    }


    /**
     * @group aa
     * @group setup
     * @group items
     * @group editItem
     */
    public function testEditQuestionName()
    {
        $testText = Factory::create()->name;

        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user, $testText ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                //call
                ->click('.add-child-to-exam-button')
                //check creation
                ->assertVisible('.item-card-component')
                ->assertVisible('#item-card-1-0')
                ->assertVisible('#item-name-1-0')
                ->type('#item-name-1-0', $testText)
                ->pause(5000)
                ->assertInputValue('#item-name-1-0', $testText);


            //make sure it persisted

            $examId = $browser->value('#examId');
            $browser->navigateToExam($examId, $user)
                ->waitForText($testText)
                ->assertVisible('.item-card-component')
                ->assertVisible('#item-card-1-0')
                ->assertInputValue('#item-name-1-0', $testText);
        });

    }

//
//    public function testAddElementToQuestion()
//    {
//
//    }
//
//
//    public function testMoveChildToBeParentsSibling()
//    {
//
//    }
//
//
//    public function testMakeParentsSiblingIntoItsChild()
//    {
//
//    }

//public function testToggleChildrenVisibility(){
//Exam case
//item case


//}


    /**
     * Checks that the toggle works for exams
     * @group setup
     * @group items
     * @group toggles
     * @todo Set up test for nested child elements
     * @todo Check that no other contents are displaying
     */
    public function testToggleItemSettingsVisibility()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                //add item
                ->click(SetupPage::$addItemToExamButton)
                ->waitFor('#item-card-1-0')
//                ->assertVisible('#item-settings-button-1-0')  //Setup::settingsToggleButton())
                ->assertVisible(Page::settingsToggleButton(1, 0))
                ->assertMissing('#item-nav-tabs-1-0')
                //click the show button
                ->click(Page::settingsToggleButton(1, 0))
//                ->waitFor('#item-nav-tabs-1-0')
                ->assertVisible('#item-nav-tabs-1-0')
                //click the hide button
                ->click(Page::settingsToggleButton(1, 0))
                ->assertMissing('#item-nav-tabs-1-0');

        });
    }

    /**
     * @group aa
     * @group setup
     * @group exam
     * @group createExam
     */
    public function testMakeExam()
    {
//        $user = factory(User::class)->create();
        Auth::loginUsingId(1);
        $exam = factory(Exam::class)->create();
//        $exam->user()->save($user);
        $order = Page::makeExamData($exam);

        $this->browse(function ( Browser $browser ) use ( $exam ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(Page::urlToExam($exam->id))
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible('#item-card-1-0')
                ->assertVisible('#item-card-2-0');

        });

    }

}
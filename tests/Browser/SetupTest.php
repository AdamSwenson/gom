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
use Tests\Browser\Pages\Setup;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SetupTest extends DuskTestCase

{
    public function testNavigationToPage()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs(User::find(1))
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible(Setup::$mainBodyLocator);
        });

    }

    public function testAddQuestionToExam()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('.add-child-to-exam-button')
                ->assertMissing('.item-card-component')
                //call
                ->click('.add-child-to-exam-button')
                ->waitFor('#item-card-1-0')
                ->assertVisible('.item-card-component')
                ->pause(2000);


            //make sure it persisted
            $examId = $browser->value('#examId');
            $browser->visit(Setup::urlToExam($examId))
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('#item-card-1-0');
        });

    }

    /**
     * Alter the exam name and make sure it persists
     */
    public function testEditExamName()
    {
        $testText = Factory::create()->name;

        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user, $testText ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('#exam-name')
                //call
                ->type('#exam-name', $testText)
                ->assertInputValue('#exam-name', $testText)
                ->pause(2000);

            //make sure it persisted
            $examId = $browser->value('#examId');
            Setup::navigateToExam($browser, $examId);
            $browser->assertVisible('#exam-name')
                ->assertInputValue('#exam-name', $testText);
        });

    }


    public function testEditQuestionName()
    {
        $testText = Factory::create()->name;

        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user, $testText ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
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
            Setup::navigateToExam($browser, $examId);
            $browser->waitForText($testText)
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
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                //add item
                ->click(Setup::$addItemToExamButton)
                ->waitFor('#item-card-1-0')
//                ->assertVisible('#item-settings-button-1-0')  //Setup::settingsToggleButton())
                ->assertVisible(Setup::settingsToggleButton(1,0))

                ->assertMissing('#item-nav-tabs-1-0')
                //click the show button
                ->click(Setup::settingsToggleButton(1,0))
//                ->waitFor('#item-nav-tabs-1-0')
                ->assertVisible('#item-nav-tabs-1-0')
                //click the hide button
                ->click(Setup::settingsToggleButton(1,0))
                ->assertMissing('#item-nav-tabs-1-0');

        });
    }

    /**
     * @group new
     */
    public function testMakeExam()
    {
//        $user = factory(User::class)->create();
        Auth::loginUsingId(1);
        $exam = factory(Exam::class)->create();
//        $exam->user()->save($user);
        $order = Setup::makeExamData($exam);

        $this->browse(function ( Browser $browser ) use ( $exam ) {
            $browser->loginAs(User::find(1))
                //prep
                ->visit(Setup::urlToExam($exam->id))
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('#item-card-1-0')
                ->assertVisible('#item-card-2-0');

        });

    }

}
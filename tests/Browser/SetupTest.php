<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/26/17
 * Time: 3:11 PM
 */

namespace Tests\Browser;

use App\User;
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
                ->waitFor('#item-card')
                ->assertVisible('.item-card-component');

            //make sure it persisted
            $examId = $browser->value('#examId');
            $browser->visit(Setup::urlToExam($examId))
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('#item-card');
        });

    }

    public function testEditQuestionName()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $testText = Factory::create()->name;
            $browser->loginAs(User::find(1))
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('.add-child-to-exam-button')
                ->assertMissing('@item-card')
                //call
                ->click('.add-child-to-exam-button')
                //check creation
                ->assertVisible('.item-card-component')
                ->type('.item-name', $testText);

            //make sure it persisted
            $examId = $browser->value('#examId');
            $browser->visit(Setup::urlToExam($examId))
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible('.item-card-component')
                ->assertVisible('.item-name')//'@itemName')
                ->assertInputValue('.item-name', $testText); //'@itemName', $testText);

        });

    }


    public function testAddElementToQuestion()
    {

    }


    public function testMoveChildToBeParentsSibling()
    {

    }


    public function testMakeParentsSiblingIntoItsChild()
    {

    }
}
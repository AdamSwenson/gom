<?php

namespace Tests\Browser;

use App\User;
use Faker\Factory;
use Tests\Browser\Pages\Kumi;
use Tests\Browser\Pages\Setup;
use Tests\Browser\Pages\StudentPane;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class KumiTest extends DuskTestCase
{
    /* ------------------------ Intact, proper display --------------------------  */

    /**
     * @group a
     * @group setup
     * @group students
     * @group kumi
     */
    public function testKumiNavTabsAreIntact()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();

            $browser->loginAs($user)
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->on(new StudentPane())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->on(new Kumi())
                ->assertVisible('@kumiTabs');
                //->assertSee('All');
        });
    }

    /* ------------------------ Sorting and display control ------------------- */
    public function testAllTabIsVisibleAndWorksWhenMoreThanOneKumi()
    {

    }



    /* ------------------------ Editing and creation ------------------------ */
    /**
     * @group a
     *
     * @group setup
     * @group roster
     * @group kumi
     * @group kumiOps
     * @group newKumi
     */
    public function testCreateNewKumi()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();
            $testName = Factory::create()->word;
            $browser->loginAs($user)
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->on(new StudentPane())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->on(new Kumi())
                ->assertVisible('@kumiTabs')
                ->assertVisible('@newKumiButton')
                ->click('@newKumiButton')
                ->assertVisible('@kumiNameFields')
                ->type("[id^='kumi-name-field-']:last-child", $testName)
//                ->fillNewKumiNameField($testName)
                //wait for client side operations
                ->pause(1000)
            ->assertKumiDbCountChanged($user, 1, 1);

//                ->refresh()
//                //check
//                ->waitFor(Setup::$mainBodyLocator)
//                ->navigateToStudentsPane()
//                ->assertVisible('.add-students-panel')
//                ->on(new Kumi())
//                ->assertVisible('@kumiTabs')
//                ->assertSee($testName);
        });
    }

    /**
     *
     *
     * @group setup
     * @group roster
     * @group kumi
     * @group kumiOps
     * @group editKumi
     */
    public function testEditKumi()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();

            $browser->loginAs($user)
                //prep
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->on(new StudentPane())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->on(new Kumi())
                ->assertVisible('@kumiTabs');
            //actions
        });
    }
}

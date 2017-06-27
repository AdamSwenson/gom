<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/26/17
 * Time: 3:11 PM
 */

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\Setup;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SetupTest extends DuskTestCase

{
    public function testNavigationToPage()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs(User::find(1))
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible(Setup::$mainBodyLocator);
        });

    }
}
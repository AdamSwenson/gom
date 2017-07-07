<?php

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\CommentSetup;
use Tests\Browser\Pages\Setup;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentSetupTest extends DuskTestCase
{
    /**
     * @group comments
     * @group setup
     */
    public function testNavigationToCommentPane()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs(User::find(1))
                ->visit(new Setup())
                ->waitFor(Setup::$mainBodyLocator)
                ->assertVisible(Setup::$mainBodyLocator);

                $browser = CommentSetup::openCommentPane($browser, 1);
            $browser->assertVisible('#comment-setup-panel-');
        });

    }

}

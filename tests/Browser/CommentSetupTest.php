<?php

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\CommentSetupPage;
use Tests\Browser\Pages\ItemCardPage;
use Tests\Browser\Pages\KumiPage;
use Tests\Browser\Pages\Page;
use Tests\Browser\Pages\StudentPanePage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentSetupTest extends DuskTestCase
{
    /**
     * @group comments
     * @group setup
     */
    public function testNavigationToStudentCommentPane()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                ->visit(new Page())
                ->waitFor(Page::$mainBodyLocator)
                ->assertVisible(Page::$mainBodyLocator)
                //add item
                ->assertVisible('@addChildButton')
                ->click('@addChildButton')
                ->on(new ItemCardPage())
                ->assertVisible('@itemSettingsButton')
                ->click('@itemSettingsButton')
                ->waitFor("a[id^='item-feedback-nav']")
                ->click("a[id^='item-feedback-nav']")

//                ->waitForLink('Feedback')
//                ->assertSeeLink('Feedback')
//                ->clickLink('Feedback')
                ->on(new CommentSetupPage())
                ->waitFor('@commentSetupPanels')
                ->assertVisible('@commentSetupPanels');
        });

    }

    /**
     * @group comments
     * @group setup
     */
    public function testNavigationToExamCommentPane()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                ->visit(new Page())
                ->waitFor(Page::$mainBodyLocator)
                ->assertVisible(Page::$mainBodyLocator)
                //open pane
                ->assertVisible('@examSettingsButton')
                ->click('@examSettingsButton')
                ->waitForLink('Feedback')
                ->assertSeeLink('Feedback')
                ->clickLink('Feedback')
                ->on(new CommentSetupPage())
                ->waitFor('@commentSetupPanels')
                ->assertVisible('@commentSetupPanels');
        });

    }
}

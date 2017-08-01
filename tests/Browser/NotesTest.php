<?php

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\NotesPage;
use Tests\Browser\Pages\SetupPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotesTest extends DuskTestCase
{
    /**
     * @group a1
     * @group notes
     * @group setup
     */
    public function testNavigationToExamNotesPanel()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new NotesPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible(SetupPage::$mainBodyLocator)
                ->click("[id^='exam-settings-button']")
                ->assertSee('Notes')
                ->clickLink('Notes')
//            ->click(' .notes-nav')
                    ->waitFor('@notesPanelArea')
                ->assertVisible('@notesPanelArea')
//                ->click('#exam-settings-button')
//                ->waitForLink('.notes-nav')
//                ->assertSeeLink('.notes-nav')
//                ->click('@notesNavButton')
//                ->assertVisible('@notesPanelArea')
                ->assertNotesPaneIntact();
        });

    }

    /**
     * @group a1
     * @group notes
     * @group setup
     */
    public function testNavigationToItemNotesPanel()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible(SetupPage::$mainBodyLocator)
                ->addItemToExam()
                ->on(new NotesPage())
                ->navigateToItemNotesPane()
                ->assertNotesPaneIntact();
        });

    }


}

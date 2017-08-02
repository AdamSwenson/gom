<?php

namespace Tests\Browser;

use App\Models\NewGom\Note;
use App\User;
use Faker\Factory;
use Tests\Browser\Pages\NotesPage;
use Tests\Browser\Pages\SetupPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Assert as PHPUnit;


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
        $this->browse(
            function ( Browser $browser ) use ( $user ) {
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
                    ->assertNotesPaneIntact();
//                ->click('#exam-settings-button')
////                ->waitForLink('.notes-nav')
////                ->assertSeeLink('.notes-nav')
////                ->click('@notesNavButton')
////                ->assertVisible('@notesPanelArea')

            }
        );

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
                ->navigateToItemNotesPanel()
                ->assertNotesPaneIntact();
        });

    }

    /**
     * @group a1
     * @group notes
     * @group setup
     */
    public function testMakeNewNote()
    {
        //test toggle
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $testText = Factory::create()->sentence();
            $testName = Factory::create()->word();

            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible(SetupPage::$mainBodyLocator)
                ->addItemToExam()
                ->on(new NotesPage())
                ->navigateToItemNotesPanel()
                ->assertNotesPaneIntact()
                //now actual test
                ->assertMissing('@newNotesArea')
                ->assertVisible('@newNoteButton')
                ->click('@newNoteButton')
                ->waitFor('@newNotesArea')
                ->assertVisible('@newNoteText')
                ->type('@newNoteText', $testText)
                ->assertVisible('@newNoteTitle')
                ->type('@newNoteTitle', $testName)
                ->pause(5000);

            Auth::login($user);
            $n = Note::where('text', $testText)
                ->where('name', $testName)
                ->first();
            PHPUnit::assertTrue(isset($n));
        });
    }

    public function testSeeAndEditExistingNote()
    {

    }

    public function testSeeAndDeleteExistingNote()
    {

    }

}

<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class NotesPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {}

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
//        $browser->assertVisible('@notesPanelArea');
    }

    public function navigateToItemNotesPanel(   Browser $browser)
    {
        return $browser
            ->click("[id^='item-settings-button']")
            ->pause(10000)
            ->assertSee('Notes')
            ->clickLink('Notes')
            ->waitFor('.panel-notes-component') //@notesPanelArea')
            ->assertVisible('.panel-notes-component'); //@notesPanelArea');
    }

    /**
     * Make sure that all expected fields and controls are visible
     * @param Browser $browser
     * @return Browser
     */
    public function assertNotesPaneIntact( Browser $browser )
    {
        return $browser
            ->assertVisible('@notesPanelArea');
//            ->assertVisible('@existingNotesArea');
    }

    public function assertNewNoteAreaVisible(Browser $browser  )
    {
        return $browser
        ->assertVisible('@newNotesArea')
        //components
        ->assertVisible('@newNoteText');

    }



    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
     //macro and stuff external to the pane/page proper
            '@notesPanelArea' => '.panel-notes-component',
            '@notesNavButton' => 'li a .notes-nav',

            //major divisions of the page
            '@existingNotesArea' => '#existing-notes-area',
            '@newNotesArea' => '#new-note-area',

            //things on the page
            '@newNoteButton' => '.new-note-button',
            '@newNoteText' => "textarea[id^='new-note-text']",
            '@newNoteTitle' => "input[id^='new-note-title']"
        ];
    }
}

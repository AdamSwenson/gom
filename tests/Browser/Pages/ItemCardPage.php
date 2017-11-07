<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class ItemCardPage extends Page
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
//        $browser->assertPathIs($this->url());

    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@itemSettingsButton' => "[id^='item-settings-button-']:last-child",
            //navs
            '@itemDetailsNavs' => '.item-details-nav',
            '@studentsNavs' => '.students-nav',
            '@examDetailsNavs' => '.exam1-details-nav',
            '@gradesNavs' => '.grades-nav',
            '@feedbackNavs' => "[id^='item-feedback-nav-']",
            '@statsNavs' => '.stats-nav',
            '@historyNavs' => '.history-nav',
            '@notesNavs' => '.notes-nav',
            '@tagsNavs' => '.tags-nav',
            ];
    }
}

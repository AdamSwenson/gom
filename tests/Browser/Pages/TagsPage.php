<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class TagsPage extends BasePage
{

    /**
     * Assumes that there is no item one yet
     * @param Browser $browser
     * @return $this
     */
    public function navigateToItemTagsPanel( Browser $browser )
    {
        return $browser
            ->on(new SetupPage())
            ->navigateToItemDetailPage();

    }

    /**
     * Make sure that all expected fields and controls are visible
     * @param Browser $browser
     * @return Browser
     */
    public function assertTagsDisplayAreaIntact( Browser $browser )
    {
        return $browser
//            ->assertVisible('.object-tag-list')
//            ->assertVisible('@tagDisplayArea')
            ->assertSee('Edit Tags');
    }

    public function assertTagsMenuVisible( Browser $browser )
    {
        return $browser
            ->assertVisible('@tagsMenuArea')
            //components
            ->assertVisible('@newTagButton')
            ->assertSee('New'); //button in unclicked state
    }

    public function toggleTagsMenu( Browser $browser )
    {
        return $browser
            ->assertSee('Edit Tags')
            ->clickLink('Edit Tags');
    }

    public function openNewTagsArea( Browser $browser )
    {
        return $browser
            ->assertVisible('@newTagButton')
            ->assertNotVisible('@newTagArea')
            ->click('@newTagButton')
            ->assertVisible('@newTagArea')
            ->assertVisible('@newTagNameField')
            ->assertSee('Save'); //the button label should change
    }


    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@tagDisplayArea' => '.tag-display-area',
            '@tagsMenuArea' => '.tags-menu',
            '@tagMenuRow' => "a[class='tag-menu-row']",
            //new tag
            '@newTagButton' => "a[class='new-tag-button']",
            '@newTagArea' => '.new-tag-input-area',
            '@newTagNameField' => '#new-tag-name',
            //The area holding the list of tags
            '@tagList' => '.object-tag-list'
        ];
    }


    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser $browser
     * @return void
     */
    public function assert( Browser $browser )
    {
    }


}

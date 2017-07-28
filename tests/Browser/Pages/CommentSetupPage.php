<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CommentSetupPage extends Page
{

    public static function openCommentPane(Browser $browser, $serialNumber){
        $path = "#/panel-comments/" + $serialNumber;
        $browser->visit($path);
        return $browser;
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
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@commentSetupPanels' => "[id^='comment-setup-panel']",
        ];
    }
}

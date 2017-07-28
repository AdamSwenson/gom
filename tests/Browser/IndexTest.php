<?php

namespace Tests\Browser;

use Tests\Browser\Pages\IndexPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class IndexTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testNavigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new IndexPage())
                    ->assertSee('gradeomatic');
        });
    }
}

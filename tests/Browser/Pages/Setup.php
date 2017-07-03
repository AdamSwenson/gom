<?php

namespace Tests\Browser\Pages;

use App\Exam;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Setup extends BasePage
{
    static public $mainBodyLocator = '#examEditor';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
//        $exam = Exam::all()->random();
        return '/items';// . $exam->id;
    }

    static public function urlToExam( $examId)
    {
        return '/items/' . $examId;
        // . $exam->id;
//        $browser->assertPathIs($this->url());
    }



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
            '@element' => '#selector',
            '@addSibling' => '.add-sibling-button',
            '@addQuestion' => 'button.add-child-to-exam-button',
        '@addChild' => '.add-child-button',
            '@item-card' => 'div .item-card-component',
            '@item-name' => 'item-name'
        ];
    }
}

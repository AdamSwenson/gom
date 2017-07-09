<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use PHPUnit\Framework\Assert as PHPUnit;

class StudentPane extends BasePage
{

    const navButton = '#exam-nav-tabs li a .students-nav';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/setup';
//        return Setup::urlToExam($examId);
//        return '/';
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
    
    public function navigateToStudentsPane(Browser $browser){
        return $browser->click('#exam-settings-button')
//            ->clickLink('Students')
////            ->waitFor('.student-nav')
            ->click(' .students-nav')
            ->assertVisible('.add-students-panel');

    }

    public function assertStudentRowCountIs(Browser $browser, $count)
    {
        PHPUnit::assertCount($count, $browser->elements('@studentRow'));
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
            '@studentRow' => '.student-row',
        '@studentNavTab' => '#exam-nav-tabs li a .students-nav'
            ];
    }
}

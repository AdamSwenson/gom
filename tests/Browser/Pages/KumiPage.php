<?php

namespace Tests\Browser\Pages;

use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;

use PHPUnit\Framework\Assert as PHPUnit;
/**
 * Class Kumi
 * This is for tests of creating and altering kumis
 * (groupings of students)
 *
 * @package Tests\Browser\Pages
 */
class KumiPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
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


    public function assertKumiDbCountChanged( Browser $browser, $user, $oldCount, $expectedDelta )
    {
        Auth::login($user);
        $newCount = \App\Kumi::all()->count();
        PHPUnit::assertEquals($oldCount + $expectedDelta, $newCount);
        Auth::logout();
    }

    public function fillNewKumiNameField(Browser $browser, $text)
    {
        //get empty field
        $fields = $browser->elements('@kumi-name-field');
        $length = sizeof($fields);
        var_dump($fields);
        $newField = $fields[$length - 1];
        $browser->type($newField, $text);

}

    public static function nameFieldId($serialNumber){
        return 'kumi-name-field-' + $serialNumber;
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@kumi-name-field' => '.kumi-name-field',
            '@kumiTabs' => '.kumi-tabs',
            '@newKumiButton' => '#new-kumi-button',
            '@editKumiButton' => '#edit-kumi-button',
            '@kumiNameFields' => "[id^='kumi-name-field-']"
        ];
    }
}

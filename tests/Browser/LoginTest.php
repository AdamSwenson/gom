<?php

namespace Tests\Browser;

use App\User;
use Faker\Factory;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testNavigateToPage()
    {
        $password = Factory::create()->word();
        $user = factory(User::class)->create(['password' => bcrypt($password)]);

        $this->browse(function ( Browser $browser ) use ( $user, $password ) {
            $browser->visit('/login')
                ->waitFor('#login')
                ->type('email', $user->email)
                ->type('password', $password)
                ->press('Login')
                ->assertPathIs('/exam');
        });
    }
}

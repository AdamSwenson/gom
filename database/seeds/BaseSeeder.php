<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Parent class for standard seeding operations
 * Class BaseSeeder
 */
class BaseSeeder extends Seeder
{
    public $user;
    public $userId = 1;
    public $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->user = User::find($this->userId);
        Auth::login($this->user);
        $this->faker = \Faker\Factory::create();

    }
}

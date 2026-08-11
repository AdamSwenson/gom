<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/18/15
 * Time: 11:10 AM
 */
class UserTableSeeder extends Seeder
{

    public function run($num=10)
    {
        $faker = \Faker\Factory::create();

        DB::table('users')->delete();

        App\User::create(
            [
                'id' => 2,
                'name' => 'scratchUser2',
                'password' => bcrypt('!goMETAdors!'),
                'email' => 'test@gradeomatic.net'
            ]
        );
        App\User::create(
            [
                'id' => 1,
                'name' => 'scratchUser1',
                'password' => bcrypt('testtest'),
                'email' => 'test2@gradeomatic.net'
            ]
        );

        for($i=0; $i<=$num; $i++)
        {
            App\User::create(['name' => $faker->userName(),
            'password' => bcrypt($faker->password()),
            'email' => $faker->email()]);
        }
    }
}
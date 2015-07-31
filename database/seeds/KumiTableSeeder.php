<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/18/15
 * Time: 12:05 PM
 */



class KumiTableSeeder extends Seeder
{

    public $faker;

    public function run($num = 10)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('kumis')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $s = new \App\Kumi();
            $s->year = $this->faker->year();
            $s->nickname = $this->faker->text(8);
            $s->save();
        }
    }

}
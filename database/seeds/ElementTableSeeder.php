<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/18/15
 * Time: 11:31 AM
 */
use Illuminate\Database\Seeder;


/**
 * Class ElementTableSeeder
 * Seeds the elements table
 */
class ElementTableSeeder extends Seeder
{

    public $faker;

    public function run($num = 10)
    {
        $this->faker = \Faker\Factory::create();

        DB::table('elements')->delete();
        for ($i = 0; $i < $num; $i++)
        {
            $element = new \App\Element([
                'elementName' => $this->faker->text(20),
                'displayText' => $this->faker->text(200),
                'commentText' => $this->faker->paragraph()
            ]);
            $element->setUser(1);
            $element->save();
        }
    }
}
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
            $name = $this->faker->text(20);
            $display = $this->faker->text(200);
            $text = $this->faker->paragraph();
            $element = new \App\Element();
            $element->elementName = $name;
            $element->displayText = $display;
            $element->commentText = $text;

            $element->save();
        }
    }
}
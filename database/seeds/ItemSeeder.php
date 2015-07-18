<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/15
 * Time: 1:56 PM
 */

use Illuminate\Database\Seeder;


class ItemSeeder extends Seeder
{

    use SeederTraits;

    public function run()
    {
        $this->setUp();
        $this->populate_items();
    }

    /**
     * Creates fake elements, comments, questions
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function populate_items($num = 10)
    {
        try
        {
            for ($i = 0; $i < $num; $i++)
            {
                $this->makeQuestion();
                $this->makeElement();
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }


    public function makeQuestion()
    {
        $q = \QuestionQuery::create()
            ->filterByUser($this->user)
            ->filterByQuestionname($this->faker->word())
            ->filterByQuestiontext($this->faker->text(50))
            ->findOneOrCreate();
        $q->save();
    }

    public function makeElement()
    {
        $el = \ElementQuery::create()
            ->filterByUser($this->user)
            ->filterByElementname($this->faker->word())
            ->filterByCommenttext($this->faker->text(900))
            ->filterByDisplaytext($this->faker->text(15))
            ->findOneOrCreate();
        $el->save();
    }


}
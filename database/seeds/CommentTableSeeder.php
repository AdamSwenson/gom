<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 5:21 PM
 */
use App\Comment;
use App\Element;
use Illuminate\Database\Seeder;


/**
 * Class CommentTableSeeder
 *
 * Seeds the comment table and the comment_element table.
 */
class CommentTableSeeder extends Seeder
{
    public $faker;

    public function loadElement($numberOfRuns)
    {
        $this->elements = Element::all()->shuffle();
        while(count($this->elements) < $numberOfRuns)
        {
            $this->elements = array_merge($this->elements, Element::all()->shuffle());
        }
//        foreach($this->elements as $e)
//        {
//            yield $e;
//        }
//        shuffle($this->elements);
    }

    public function run($num = 10)
    {
        $this->faker = \Faker\Factory::create();
    $this->loadElement($num);

        DB::table('comments')->delete();
        DB::table('comment_element')->delete();

        for ($i = 0; $i < $num; $i++)
        {
//            try
//            {
                foreach (Comment::$valences as $valence)
                {
                    $e = $this->elements[$i];
$body = $this->faker->text();
                    $comment = new Comment();
                    $comment->setValence($valence);
                    $comment->setBody($body);
                    $comment->save();
                    $comment->element()->save($e);



                }


//            } catch (\Exception $e)
//            {
//var_dump($e);
//            }
        }
    }
}
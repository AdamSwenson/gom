<?php
namespace Database\Seeders;

use App\Exam;
use App\Item;
use App\Models\NewGom\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends BaseSeeder
{


    static public function populateExamAndItemsWithTags(Exam $exam, $numberTags){

        //create tags for exam
        $tags = Tag::factory()->count($numberTags)->create();
        $exam->tags()->attach($tags);

        //seed tag items
        $items = $exam->getItems();

        foreach($items as $item){
            $item->tags()->attach(Tag::factory()->count($numberTags)->create());
            $item->save();
        }
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parent::run();

        $numberTags = 5;

        Auth::loginUsingId($this->userId);
        DB::table('tags')->delete();

        $tags = Tag::factory()->count($numberTags)->create();

        $items = Item::all();
        $exams = Exam::all();

        //seed exams and item tags
        foreach ( $tags as $tag ) {
            foreach ( $exams->concat($items) as $item ) {
                $item->tags()->attach($tag);
                $item->save();
            }
        }
    }
}

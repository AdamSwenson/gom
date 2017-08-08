<?php

use App\Exam;
use App\Item;
use App\Models\NewGom\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends BaseSeeder
{
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

        $tags = factory(Tag::class, $numberTags)->create();

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

<?php

use App\Exam;
use App\Item;
use App\Models\NewGom\Note;
use Illuminate\Database\Seeder;

class NoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->faker = \Faker\Factory::create();

        Auth::loginUsingId(1);

        DB::table('notes')->delete();
        $items = Item::all();
        $exams = Exam::all();


        //seed note items
        foreach ( $exams->concat($items) as $item ) {
            $note = factory(Note::class)->create();
            $item->notes()->attach($note);
            $item->save();
        }
    }
}

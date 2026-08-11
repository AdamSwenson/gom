<?php
namespace Database\Seeders;

use App\Exam;
use App\Item;
use App\Models\NewGom\Note;
use Illuminate\Database\Seeder;

class NoteTableSeeder extends Seeder
{

    static public function populateExamAndItemsWithNotes(Exam $exam, $numberNotes){

        //create notes for exam
        $notes = Note::factory()->count($numberNotes)->create();
        $exam->notes()->attach($notes);

        //seed note items
        $items = $exam->getItems();

        foreach($items as $item){
            $item->notes()->attach(Note::factory()->count($numberNotes)->create());
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

        $this->faker = \Faker\Factory::create();

        Auth::loginUsingId(1);

        DB::table('notes')->delete();
        $items = Item::all();
        $exams = Exam::all();


        //seed note items
        foreach ( $exams->concat($items) as $item ) {
            $note = Note::factory()->create();
            $item->notes()->attach($note);
            $item->save();
        }
    }
}

<?php

use App\Models\NewGom\Tag;
use App\QuestionAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * This creates the db for the new gom
 *
 *
 * Class DevDatabaseSeeder
 */
class DevDatabaseSeeder extends BaseSeeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserTableSeeder::class);
        \Auth::loginUsingId($this->userId);
        $this->call(ExamTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(KumiTableSeeder::class);
        $this->call(KumiAssociationsSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(AssignmentsTableSeeder::class);
        $this->call(NoteTableSeeder::class);
        $this->call(ItemScoreSeeder::class);
        $this->call(TagTableSeeder::class);
        Model::reguard();
    }
}

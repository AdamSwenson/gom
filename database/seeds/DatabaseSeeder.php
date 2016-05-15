<?php

use App\QuestionAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = [
        'element_scores',
        'question_scores',
        'exam_kumi',
        'kumi_student',

        'element_assignments',
        'question_assignments',

        'kumis',
        'comments',
        'elements',
        'questions',
        'students',
        'exams'

    ];

    /**
     * DOES NOT WORK
     */
    public function runTruncate()
    {
        foreach($this->toTruncate as $t)
        {
            DB::table($t)->truncate();
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $this->call(UserTableSeeder::class);
        \Auth::loginUsingId(1);
        $this->call(ExamTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(ElementTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(KumiTableSeeder::class);
        $this->call(QuestionAssignmentTableSeeder::class);
        $this->call(QuestionScoresTableSeeder::class);
        $this->call(ElementAssignmentTableSeeder::class);
        $this->call(ElementScoresTableSeeder::class);
        $this->call(KumiAssociationsSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(GradingTimeSeeder::class);
        $this->call(GradeAssignmentSeeder::class);
        //$this->call('ItemSeeder');
        //$this->call('ItemAssignmentSeeder');
        $this->call(AccessKeysTableSeeder::class);
        $this->call(FeedbackTableSeeder::class);
        Model::reguard();
    }
}

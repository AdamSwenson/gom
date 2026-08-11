<?php
namespace Database\Seeders;

use App\QuestionAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * All values for seeding should be defined
     * as constants here.
     *
     * Tests which need to know these values may
     * refer to them directly here.
     */
    const NUMBER_EXAMS = 5;

    const NUMBER_TAGS = 5;
    const NUMBER_NOTES = 2;

    const NUMBER_STUDENTS_PER_KUMI = 20;
    const NUMBER_KUMI_PER_EXAM = 3;

    /** @var int The number of items at each level */
    const NUMBER_ITEMS_PER_LEVEL = 2;
    const NUMBER_LEVELS = 2;

    /** The maximum score for any item on the exam */
    const MAX_ITEM_SCORE = 100;
    /** Whether different items will have different max scores.
     * If this is true, no item score will be 0
     * and no item score will exceed MAX_ITEM_SCORE
     * If it is false, all items will have MAX_ITEM_SCORE
     */
    const VARY_MAX_ITEM_SCORES = true;



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

        //todo dev not using these while working on dev
//        $this->call(QuestionAssignmentTableSeeder::class);
//        $this->call(QuestionScoresTableSeeder::class);
//        $this->call(ElementAssignmentTableSeeder::class);
//        $this->call(ElementScoresTableSeeder::class);
//        $this->call(KumiAssociationsSeeder::class);
//        $this->call(CommentTableSeeder::class);
//        $this->call(GradingTimeSeeder::class);
//        $this->call(GradeAssignmentSeeder::class);
//        //$this->call('ItemSeeder');
        //$this->call('ItemAssignmentSeeder');
//        $this->call(AccessKeysTableSeeder::class);
//        $this->call(FeedbackTableSeeder::class);

        //      dev
        for($i=0; $i< self::NUMBER_EXAMS; $i++){
            CompleteNewSetupSeeder::makeCompleteExam(self::NUMBER_LEVELS, self::NUMBER_ITEMS_PER_LEVEL, self::NUMBER_KUMI_PER_EXAM, self::NUMBER_STUDENTS_PER_KUMI, self::NUMBER_NOTES, self::NUMBER_TAGS);
        };

//        $this->call(CompleteNewSetupSeeder::class);
//        $this->call(AssignmentsTableSeeder::class);
//        $this->call(NoteTableSeeder::class);

        //dev
//        $this->call(DevSeeder::class);
        Model::reguard();
    }
}

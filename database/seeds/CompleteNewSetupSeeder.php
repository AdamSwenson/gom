<?php

use App\Exam;
use Illuminate\Database\Seeder;

/**
 * Creates entire exams under the new setup structure
 * So, there is a complete set of:
 * items
 * comments
 * students
 * notes
 * tags
 * scores
 * grading times
 * Class CompleteNewSetupSeeder
 */
class CompleteNewSetupSeeder extends Seeder
{
    const NUMBER_TAGS = 5;
    const NUMBER_NOTES = 2;

    /** @var int The number of items at each level */
    public $numAtLevel = 2;
    public $numLevels = 2;

    /**
     * @param $numLevels
     * @param int $numAtLevel
     * @param $numKumi
     * @param $studentsPerClass
     * @return mixed
     */
    static public function makeCompleteExam( $numLevels, $numAtLevel, $numKumi, $studentsPerClass )
    {
        $exam = factory(Exam::class)->create();

        //add items
        AssignmentsTableSeeder::populateExam($exam, $numLevels, $numAtLevel);

        //add kumis and students
        KumiAssociationsSeeder::populateExamWithKumiAndStudents($exam, $numKumi, $studentsPerClass);

        //at notes
        NoteTableSeeder::populateExamAndItemsWithNotes($exam, self::NUMBER_NOTES);

        //add tags
        TagTableSeeder::populateExamAndItemsWithTags($exam, self::NUMBER_TAGS);

        //add scores
        ItemScoreSeeder::populateExamWithScores($exam);

        //add grading times
        GradingTimeSeeder::populateExamWithGradingTimes($exam);

        return $exam;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::makeCompleteExam($this->numLevels, $this->numAtLevel, $this->numKumi, $this->studentsPerClass);
        //
    }
}

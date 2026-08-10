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
    /**
     * @param $numLevels
     * @param int $numAtLevel
     * @param $numKumi
     * @param $studentsPerClass
     * @return mixed
     */
    static public function makeCompleteExam($numLevels, $numAtLevel, $numKumi, $studentsPerClass, $numberNotes, $numberTags)
    {
        $exam = Exam::factory()->create();

        //add items
        AssignmentsTableSeeder::populateExam($exam, $numLevels, $numAtLevel);

        //add kumis and students
        KumiAssociationsSeeder::populateExamWithKumiAndStudents($exam, $numKumi, $studentsPerClass);

        //at notes
        NoteTableSeeder::populateExamAndItemsWithNotes($exam, $numberNotes);

        //add tags
        TagTableSeeder::populateExamAndItemsWithTags($exam, $numberTags);

        //add scores
        ItemScoreSeeder::populateExamWithScores($exam);

        //add grading times
        GradingTimeSeeder::populateExamWithGradingTimes($exam);

        GradeAssignmentSeeder::populateExamWithGradeAssignments($exam);

        return $exam;
    }

    public function run()
    {
    }
}

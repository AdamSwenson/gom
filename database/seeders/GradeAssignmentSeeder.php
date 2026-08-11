<?php
namespace Database\Seeders;

use App\Exam;
use App\Grade;
use App\GradeAssignment;
use App\Repositories\Grade\GradeFactory;
use Illuminate\Database\Seeder;

class GradeAssignmentSeeder extends Seeder
{

    const DEFAULT_TOTAL_SCORE = 100;

    static public function populateExamWithGradeAssignments( Exam $exam )
    {

        $maxScore = $exam->getMaxPossibleScore() ? $exam->getMaxPossibleScore() : self::DEFAULT_TOTAL_SCORE;

        //create the grades if needed
        if ( is_null(Grade::where('group', 0)->get()) ) {
            GradeFactory::initializeStandardGrades();
        }

        //create and assign grade distributions
        foreach ( Grade::all() as $grade ) {
            $minScore = $grade->default_cutoff * $maxScore;
            $ga = new GradeAssignment();
            $ga->min_score = $minScore;
            $ga->exam()->associate($exam);
            $ga->grade()->associate($grade);
            $ga->save();
        }

    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams = \App\Exam::all();
        foreach ( $exams as $exam ) {

            self::populateExamWithGradeAssignments($exam);
//
//        $userId = $exam->user_id;
//        $examId = $exam->id;
//
//        //create the grades
//        GradeFactory::initializeStandardGrades();
//
//        //create distributions
//        foreach ( Grade::all() as $grade ) {
//            $minScore = $grade['default_cutoff'] * $standardTotalScore;
//            $ga = new GradeAssignment();
//            $ga->min_score = $minScore;
//            $ga->exam_id = $examId;
//            $ga->user_id = $userId;
//            $ga->grade_id = $grade->id;
//            $ga->save();
//        }

        }

    }
}

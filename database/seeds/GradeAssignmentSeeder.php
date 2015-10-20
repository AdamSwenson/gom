<?php

use App\GradeAssignment;
use Illuminate\Database\Seeder;

class GradeAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $standardTotalScore = 50;

        $exams = \App\Exam::all();
        foreach($exams as $exam)
        {
            $userId = $exam->user_id;
            $examId = $exam->id;

            foreach(\App\Repositories\Grade\GradeFactory::$grades as $grade)
            {
                $minScore = $grade['default_cutoff'] * $standardTotalScore;
                $ga = new GradeAssignment();
                $ga->min_score = $minScore;
                $ga->exam_id = $examId;
                $ga->user_id = $userId;
                $ga->grade_id = $grade['grade_id'];
                $ga->save();
            }

        }
    }
}

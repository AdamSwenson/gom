<?php
namespace Database\Seeders;

use App\Exam;
use App\GradingTime;
use App\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GradingTimeSeeder extends Seeder
{
    static public function populateExamWithGradingTimes( Exam $exam )
    {
        $kumis = $exam->kumis;

        foreach ( $kumis as $kumi ) {
            $students = $kumi->students;
            foreach ( $students as $student ) {

                //To save time since we're already going through the
                //loop, we'll do the grading time too
                $time = new GradingTime();
                $time->exam_id = $exam->id;
                $time->student_id = $student->id;
                $time->seconds = Factory::create()->randomFloat(2, 0, 1000);
                $time->save();
            }
        }
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('grading_times')->delete();

        $students = Student::all();
        $exams = Exam::all();
        foreach ( $students as $s ) {
            foreach ( $exams as $e ) {
                $t = new \App\GradingTime();
                $t->exam_id = $e->id;
                $t->student_id = $s->id;
                $t->seconds = \Faker\Factory::create()->randomFloat(2, 0, 500);
                $t->updated_at = \Faker\Factory::create()->dateTimeThisMonth();
                $t->save();
            }
        }
    }
}

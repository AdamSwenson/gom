<?php

use App\Exam;
use App\Student;
use Illuminate\Database\Seeder;

class GradingTimeSeeder extends Seeder
{
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
        foreach($students as $s)
        {
            foreach($exams as $e)
            {
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

<?php

use Illuminate\Database\Seeder;

/**
 * Class KumiAssociationsSeeder
 * Populates the exam and kumi junction table and also the students and kumi table
 */
class KumiAssociationsSeeder extends Seeder
{
    public $exams;
    public $students;
    public $kumis;
    public $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_kumi')->delete();
        DB::table('kumi_student')->delete();

        $this->exams = \App\Exam::all();

        $this->students = \App\Student::all();
        $this->kumis = \App\Kumi::all();

        $this->faker = Faker\Factory::create();

        $this->populateExamKumi();
        $this->populateStudentKumi();

    }

    protected function populateExamKumi()
    {

        foreach($this->exams as $exam)
        {
         //   $exam->user()->attach(\App\User::findOrNew(1));
            try
            {
                $exam->classes()->attach(\App\Kumi::all()->random());
                $exam->classes()->attach(\App\Kumi::all()->random());
            }catch(\Exception $e){}
            //$this->faker->randomElement($this->kumis));
        }
    }

    protected function populateStudentKumi($studentsPerClass=5)
    {

        foreach($this->kumis as $kumi)
        {
            for($i=0; $i<=$studentsPerClass; $i++)
            try
            {
                $kumi->students()->attach(\App\Student::all()->random());
            }catch(\Exception $e){
//                $i -=1;
            }
        }
    }
}

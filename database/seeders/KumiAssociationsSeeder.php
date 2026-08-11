<?php
namespace Database\Seeders;

use App\Exam;
use App\Kumi;
use App\Student;
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

    /**
     * Populates an exam with the specified number of kumis and students.
     *
     * @param Exam $exam
     * @param $numberKumi
     * @param $studentsPerClass
     */
    static public function populateExamWithKumiAndStudents( Exam $exam, $numberKumi, $studentsPerClass )
    {

        //create some kumis and associate them with the exam
        $kumis = Kumi::factory()->count($numberKumi)->create();
        $exam->classes()->attach($kumis);

        //now give each kumi some students
        foreach ( $kumis as $kumi ) {
            $students = Student::factory()->count($studentsPerClass)->create();
            $kumi->students()->attach($students);
        }
    }


    protected function populateExamKumi()
    {
        $cnt = 0;

        foreach ( $this->exams as $exam ) {
            try {
                $exam->classes()->attach($this->kumis[$cnt]);
//                $exam->classes()->attach(\App\Kumi::all()->random());
                // $exam->classes()->attach(\App\Kumi::all()->random());
            } catch (\Exception $e) {
            }
            $cnt += 1;
        }
    }

    /**
     * This seeds the students_kumi table with 10 students per kumi and one student shared between two kumis
     * to simulate someone in multiple classes.
     * @param int $studentsPerClass
     */
    protected
    function populateStudentKumi( $studentsPerClass = 10 )
    {
        $cnt = 0;
        foreach ( $this->kumis as $kumi ) {
            for ( $i = 0; $i <= $studentsPerClass; $i++ ) {
                try {
                    $kumi->students()->attach($this->students[$i + $cnt]);
//                $kumi->students()->attach(\App\Student::all()->random());
                } catch (\Exception $e) {
//                $i -=1;
                }
            }
            $cnt += $studentsPerClass;
        }
    }
}

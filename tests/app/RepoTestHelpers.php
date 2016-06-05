<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/16
 * Time: 1:01 PM
 */

namespace App\Repositories;


use App\Exam;
use App\Kumi;
use App\Student;

class RepoTestHelpers extends \TestCase
{
    public $studentIds;
    public $students;
    public $kumi;
    public $exam;
    public $student;
    protected $object;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    public function setupExamWithStudents(){
        $this->kumi = factory(Kumi::class)->create();
        $this->exam = factory(Exam::class)->create();
        $this->kumi->exams()->attach($this->exam);
        //create students and put in expected order
        $this->students = factory(Student::class, 5)->create();
        $this->students = $this->students->sortBy('last_name');
        $this->studentIds = [];
        foreach ( $this->students as $item )
        {
            $this->kumi->students()->attach($item);
            $this->studentIds[] = $item->id;
        }
        $this->kumi->push();
    }

//    public static function setupExamWithStudents($dthis){
//        $dthis->kumi = factory(Kumi::class)->create();
//        $dthis->exam = factory(Exam::class)->create();
//        $dthis->kumi->exams()->attach($dthis->exam);
//        //create students and put in expected order
//        $dthis->students = factory(Student::class, 5)->create();
//        $dthis->students = $dthis->students->sortBy('last_name');
//        $dthis->studentIds = [];
//        foreach ( $dthis->students as $item )
//        {
//            $dthis->kumi->students()->attach($item);
//            $dthis->studentIds[] = $item->id;
//        }
//        $dthis->kumi->push();
//    }

}
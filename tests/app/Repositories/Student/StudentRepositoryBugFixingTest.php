<?php
/**
 * Created by PhpStorm.
 * User: ars62917
 * Date: 4/11/16
 * Time: 2:17 PM
 */

namespace App\Repositories\Student;

use App\Exam;
use App\Http\Controllers\helpers\validation\StudentRecordValidator;
use App\Http\Requests\StudentRequest;
use App\Kumi;
use App\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class StudentRepositoryBugFixingTest extends \ReseedingTestCase
{

    protected $object;

    public function setUp()
    {
        \Mockery::close();
        parent::setUp();

        //reseed
        $this->prepareDatabase();

        $this->object = new StudentRepository;

        $this->student = Student::all()->random();
    }

    public function tearDown()
    {
        $this->prepareDatabase();

    }


    /**
     * This is based on a bug (GOM-189)
     * @test
     */
    public function deleteAllStudentsWhenIncomingRosterIsEmpty()
    {
        #prep
        $exam = Exam::find(1);
        $existingStudents = $exam->getAllAssociatedStudents();
        //make sure there are students associated with the exam
        $this->assertTrue(count($existingStudents) > 0, "At least one student associated with exam");
        $emptyRequest = new StudentRequest();

        #call
        $this->object->update_all($exam, $emptyRequest);

        foreach($existingStudents as $s){
            $this->assertTrue($s->id > 0, "stored student retains valid id (despite being removed from db");
            $this->dontSeeInDatabase('students', ['id' => $s->id]);
        }

    }
}

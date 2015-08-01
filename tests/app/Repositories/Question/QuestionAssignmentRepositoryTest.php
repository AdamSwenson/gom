<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 6:43 PM
 */

namespace App\Repositories\Question;


use App\Exam;
use App\Question;
use App\QuestionAssignment;
use Illuminate\Support\Facades\DB;

class QuestionAssignmentRepositoryTest extends \TestCase
{

    public $question;
    public $exam;
    public $assignment;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionAssignmentRepository();
        $this->question = Question::all()->random();
        $this->exam = Exam::all()->random();
        $this->assignment = QuestionAssignment::all()->random();
    }


    public function testLoad()
    {
        $qid = $this->assignment->question_number;
        $eid = $this->assignment->exam_id;

        $result = $this->object->load($eid, $qid);

        $this->assertInstanceOf('App\QuestionAssignment', $result);
    }

    public function testLoadByIds()
    {
        $qid = $this->assignment->question_id;
        $eid = $this->assignment->exam_id;
        $result = $this->object->loadByIds($eid, $qid);
        $this->assertTrue(is_integer($result));
    }


    public function testRecord()
    {
        $qnum = 4;
        $result = $this->object->record($this->exam->getId(), $this->question->getId(), $qnum);
      //  $this->assertInstanceOf('App\QuestionAssignment', $result);
        $this->seeInDatabase('question_assignments',
            ['exam_id' => $this->exam->getId(), 'question_id' => $this->question->getId(), 'question_number' => $qnum]);
    }

    public function testRecordUpdatePreexisting()
    {
        $preexisting = DB::table('question_assignments')->first();
        $eid = $preexisting->exam_id;
        $qnum = $preexisting->question_number;
        $questionId = $preexisting->question_id;

        $question = Question::where('id', '!=', $questionId);
        $qid = $this->question['id'];

        $result = $this->object->record($eid, $qid, $qnum); //going directly to id because may be query builder object

        //  $this->assertInstanceOf('App\QuestionAssignment', $result);

        $this->seeInDatabase('question_assignments',
            ['exam_id' => $eid, 'question_id' => $this->question->id, 'question_number' => $qnum]);
    }


    public function testLoad_all_for_exam()
    {
        $result = $this->object->load_all_for_exam($this->assignment->exam_id);
        $this->assertNotEmpty($result);
        $nums = [];
        foreach ($result as $r)
        {
            $this->assertInstanceOf('App\QuestionAssignment', $r);
            array_push($nums, $r->question_number);
        }
        for($i=0; $i<count($nums); $i++)
        {
            $next = $i + 1;
            if($next != count($nums)){
                $this->assertTrue($nums[$i] < $nums[$next]);
            }

        }

    }


    function testRemove()
    {
        $aid = $this->assignment->getId();
        $result = $this->object->remove($this->assignment->exam_id, $this->assignment->question_id);
        $this->assertNotEmpty($result);
        $this->notSeeInDatabase('question_assignments', ['id' => $aid]);
    }

}

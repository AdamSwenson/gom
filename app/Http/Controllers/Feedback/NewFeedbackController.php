<?php

namespace App\Http\Controllers\Feedback;

use App\Assignment;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Models\NewGom\ItemScore;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Grade\StudentGradeRepositoryNew;
use App\Repositories\Score\ITotalScoreRepository;
use App\Student;
use Illuminate\Http\Request;

class NewFeedbackController extends Controller
{

    const EXAM_JSON_NAME = 'loadedExam';
    const ITEM_ORDER_JSON_NAME = 'loadedItemOrder';
    const ITEM_OBJECT_JSON_NAME = 'loadedItemObjects';
    const KUMIS_JSON_NAME = 'loadedKumis';

    public $studentGradeRepository;
    /**
     * @var ITotalScoreRepository
     */
    private $totalScoreRepository;

    public function __construct(ITotalScoreRepository $totalScoreRepository)
    {
        $this->studentGradeRepository = new StudentGradeRepositoryNew();
        $this->totalScoreRepository = $totalScoreRepository;
    }

    protected function buildDataOutput(Exam $exam, Student $student){
        $out = [];

        $out['exam'] = $exam;
        $out['student'] = $student;

        //overall score and grade
        $gradeAssignment = $this->studentGradeRepository->getStudentGrade($exam, $student);
        $out['letterGrade'] = $gradeAssignment->getDisplayValue();
        $out['totalScore'] = $this->studentGradeRepository->calculateTotalScoreForStudent($exam, $student);

        //average total score
        $scores = $this->totalScoreRepository->getTotalScoresForExam($exam);
        $out['avgTotalScore'] = $scores->average();

        //add individual item scores
        $out['scores'] = ItemScore::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->get();

        //Item and item order data
        $assignmentDao = app()->make(IAssignmentRepository::class);
        //This adds the keys
        //  'itemObjects'
        //  'itemOrder'
        $out += $assignmentDao->getItemOrderForClient($exam);

        return $out;
    }

    /**
     * Returns the view for the student
     * feedback
     *
     *
     * @param Exam $exam
     * @param Student $student
     * @return void
     */
    public function show( Exam $exam, Student $student )
    {
        $out = $this->buildDataOutput($exam, $student);

        return view('new.newfeedback', $out);
//
//        $out['exam'] = $exam;
//        $out['student'] = $student;
//
//        //overall score and grade
//        $gradeAssignment = $this->studentGradeRepository->getStudentGrade($exam, $student);
//        $out['letterGrade'] = $gradeAssignment->getDisplayValue();
//        $out['totalScore'] = $this->studentGradeRepository->calculateTotalScoreForStudent($exam, $student);
//
//        //average total score
//        $scores = $this->totalScoreRepository->getTotalScoresForExam($exam);
//        $out['avgTotalScore'] = $scores->average();
//
//        //add individual item scores
//        $out['scores'] = ItemScore::where('student_id', $student->id)
//            ->where('exam_id', $exam->id)
//            ->get();
//
//        //Item and item order data
//        $assignmentDao = app()->make(IAssignmentRepository::class);
//        //This adds the keys
//        //  'itemObjects'
//        //  'itemOrder'
//        $out += $assignmentDao->getItemOrderForClient($exam);

//        $kumis = $exam->kumis()->get();
//
//        if ( $kumis->count() === 0 ) {
//            //if there isn't one, we need it
//            $kumi = Kumi::create();
//            $exam->kumis()->attach($kumi->id);
//            $kumis = $exam->kumis()->get();
//        }
//        $scores = ItemScore::where('student_id', $student->id)
//            ->where('exam_id', $exam->id)
//            ->get();

//        //So we add some additional elements that the page expects
//        $standard = [
//            'exam' => $exam,
//            'student' => $student,
//            'scores' => $scores
//        ];

//        $out += $standard;


    }

    public function showPublicFeedback($accessKey){

//        $out = $this->buildDataOutput($exam, $student);

//        return view('new.newfeedback', $out);
    }


    public function createkeys(Exam $exam){
        $keyRepo = app()->make(IAccessKeyRepository::class);

        $rosterKumi = $exam->roster();
        $students = $rosterKumi->students()->get();
        foreach ( $students as $student ) {
            $keyRepo->createAccessKey($exam->id, $student->id);
        }

        return $this->sendAjaxSuccess();

    }
}

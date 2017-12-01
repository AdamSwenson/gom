<?php

namespace App\Http\Controllers\Analytics;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Jobs\AsyncStorage\UpdateAllStoredNumGraded;
use App\Repositories\Exam\INumberGradedRepository;
use App\Repositories\Exam\IStoredExamStatsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamCountsController extends Controller
{

    public function getStudentCountForExam(Exam $exam){
        $count = 0;
        $kumis = $exam->kumis()->get();
        foreach ( $kumis as $kumi ) {
            $students = $kumi->students()->get();
            $count += $students->count();
//            foreach ( $students as $student ) {
//                $s = StudentResourceController::convertOutgoing($student);
//                $s['kumiId'] = $kumi->id;
//                $out[] = $s;
//
//            }

        }
        return $count;
    }

    public function getNumberGradedFromSql(Exam $exam){

        $query = <<<MYSQL
        SELECT count( DISTINCT student_id) AS numberGraded
        FROM item_scores 
        WHERE exam_id = :examId;
MYSQL;
        //get counts
        $result = DB::select($query, ['examId' => $exam->id]);
        $numberGraded = $result[0]->numberGraded;

        return !empty($numberGraded) ? $numberGraded : 0 ;
    }

    /**
     * Returns the total number of students for the exam,
     * the total number of graded exams,
     * and remaining exams
     * @param Exam $exam
     * @return array
     */
    public function getExamCounts(Exam $exam){

//        $this->dispatch(new UpdateAllStoredNumGraded());


        $storedExamStatsDao = app()->make(IStoredExamStatsRepository::class);
        $numGradedDao = app()->make(INumberGradedRepository::class);

        $out = [];
        $out['exam'] = $exam;
        $out['numStudents'] = $this->getStudentCountForExam($exam);
        $out['numGraded'] = $this->getNumberGradedFromSql($exam);

    //    $out['numStudents'] = $storedExamStatsDao->getNumberStudents($exam);
//        $out['numGraded'] =$numGradedDao->getNumberGraded($exam);

        return $out;
    }
}

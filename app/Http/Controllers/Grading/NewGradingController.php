<?php

namespace App\Http\Controllers\Grading;

use App\Comment;
use App\Grade;
use App\GradeAssignment;
use App\Http\Controllers\Controller;

use App\Http\Requests\GradeAssignmentRequest;
use App\Http\Requests\GradingRequest;

use App\Exam;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use App\Jobs\AsyncStorage\UpdateAllStoredNumGraded;
use App\Jobs\AsyncStorage\UpdateStoredExamStats;
use App\Jobs\AsyncStorage\UpdateStoredNumGraded;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Grade\GradeFactory;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;

use App\Repositories\Utilities\IJsDataPreparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use JavaScript;

class NewGradingController extends Controller
{

    /**
     * @var IAssignmentRepository
     */
    private $assignmentRepository;

    public function __construct( IAssignmentRepository $assignmentRepository)
    {
        $this->middleware('auth');
        $this->assignmentRepository = $assignmentRepository;
    }


    /**
     * Returns the new dev grading page
     * @param Exam $exam
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Exam $exam){
return view('development.newgrading', ['exam' => $exam]);
    }

    public function getItems(Exam $exam){
        $out = $this->assignmentRepository->getItemOrderForClient($exam);

        //The returned array  will have the keys
        //  'itemObjects'
        //  'itemOrder'
        return $out;
    }


}
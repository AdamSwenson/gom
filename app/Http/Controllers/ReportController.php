<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 11:22 AM
 */

namespace App\Http\Controllers;

use App\Events\ExamReleasedEvent;
use App\Exam;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Feedback\FeedbackBuilder;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * @var IStudentRepository
     */
    private $studentRepository;

    /**
     * @param IQuestionAssignmentRepository $questionAssignmentRepository
     * @param IElementAssignmentRepository $elementAssignmentRepository
     * @param IQuestionScoreRepository $questionScoreRepository
     * @param IElementScoreRepository $elementScoreRepository
     * @param ICommentRepository $commentRepository
     * @param IStudentRepository $studentRepository
     */
    public function __construct(
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IElementAssignmentRepository $elementAssignmentRepository,
        IQuestionScoreRepository $questionScoreRepository,
        IElementScoreRepository $elementScoreRepository,
        ICommentRepository $commentRepository,
    IStudentRepository $studentRepository
    ) {
        Auth::loginUsingId(1);
        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
        $this->studentRepository = $studentRepository;
    }


    public function showGradeAssign(){
        return "Grade assignment page here";
    }

    public function createFeedback()
    {
        $exam = new Exam();
        $exam->id = 1;

        event(new ExamReleasedEvent($exam));

        return view('feedback.progress_compiling');

//
//        $feedbackBuilder = new FeedbackBuilder();
//
//        $feedback = $feedbackBuilder->buildFeedback($exam->getId());
//        $accessKeys = array_keys($feedback);
////        dd($feedback[5]);
//        $data = $feedback[$accessKeys[0]];

     //   return view('feedback.feedback', compact('data'));
    }
}
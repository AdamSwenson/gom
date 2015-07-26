<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:22 PM
 */

namespace App\Http\Controllers;


use App\classes\CommentClasses\display\OutputComments;
use App\classes\ElementClasses\dao\ElementAssignmentDAO;
use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\JsonOutputClasses\encoders\DirectJsonOutput;
use App\Http\Controllers\helpers\ExamSelectorHelper;

/**
 * DEPRECATED
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * @deprecated
 * Class SetupController
 * @package App\Http\Controllers
 */
class SetupController extends Controller
{

    public $exam;

    public $examSelectorHelper;

    public function __construct()
    {
        $current_exam_manager = new CurrentExamManager();
        $this->exam = $current_exam_manager->get_current_exam();
        $this->examSelectorHelper = new ExamSelectorHelper();
    }

    public function showQuestionCreate($numQuestions = 5)
    {
        $out = [
            'numberOfQuestions' => $numQuestions,
            'pageTitle' => 'Setup questions',
            'inPageTitle' => "Create questions"
        ];

        return view('setup/question_create', $this->examSelectorHelper->makeExamSelectorComponent($out));
    }


    public function showElementCreate($numQuestions = 5, $numSubtasks = 3)
    {
        $comment_getter = new OutputComments();
        $comment_getter->set_encoder(new DirectJsonOutput());
        $comment_getter->set_loader(new ElementAssignmentDAO());
        $allComments = $comment_getter->display_all();
//
        $currentComments = !empty($this->exam) ? $comment_getter->display_for_exam($this->exam) : [];
//$allComments = json_encode([]);
//        $currentComments = json_encode([]);

        $out = [
            'allComments' => $allComments,
//            'allComments' => json_encode($allComments, \JSON_FORCE_OBJECT),
            'currentComments' => $currentComments,
            'pageTitle' => 'Set up elements',
            "inPageTitle" => "Create questions tasks and configure comments",
            'numberOfQuestions' => $numQuestions,
            'numberOfSubtasks' => $numSubtasks
        ];

        return view('setup/element_create', $this->examSelectorHelper->makeExamSelectorComponent($out));
    }


    public function showExamCreate()
    {
        return view('setup/exam_create',
            [
                'pageTitle' => 'Create new exam'
            ]);
    }



}
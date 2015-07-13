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

class SetupController extends Controller
{

    public $exam;

    public function __construct()
    {
        $current_exam_manager = new CurrentExamManager();
        $this->exam = $current_exam_manager->get_current_exam();
    }

    public function showQuestionCreate($numQuestions = 5)
    {
        $out = [
            'numberOfQuestions' => $numQuestions,
            'pageTitle' => 'Setup questions',
            'inPageTitle' => "Create questions"
        ];

        return view('setup/question_create', $this->makeExamSelectorComponent($out));
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

        return view('setup/element_create', $this->makeExamSelectorComponent($out));
    }


    public function showExamCreate()
    {
        return view('setup/exam_create',
            [
                'pageTitle' => 'Create new exam'
            ]);
    }


    public function makeExamDisplayText($exam)
    {
        $text = $exam->getExamyear() . ' ' . $exam->getExamterm() . '  ' . $exam->getExamtopic();
        return $text;
    }

    public function makeExamArray()
    {
        $exams = \ExamQuery::create()->find();
        $examList = array();
        if (count($exams) > 0)
        {
            foreach ($exams as $e)
            {
                array_push($examList, [
                    'optionId' => $e->getId(),
                    'optionValue' => $e->getId(),
                    'optionText' => $this->makeExamDisplayText($e)
                ]);
            }
        }

        return $examList;
    }

    /**
     * Takes the array that's about to go to the view and
     * adds the bits for the exam selector
     * @param array $outArray
     * @return array
     */
    public function makeExamSelectorComponent(array $outArray)
    {
        if ($this->exam)
        {
            $outArray['currentExamId'] = $this->exam->getId();
            $outArray['currentExamString'] = $this->makeExamDisplayText($this->exam);
        } else
        {
            $outArray['currentExamId'] = '';
            $outArray['currentExamString'] = '';
        }
        $outArray['examOptions'] = $this->makeExamArray();

        return $outArray;
    }


}
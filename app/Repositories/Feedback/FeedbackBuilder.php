<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 5:55 PM
 */

namespace Repositories\Feedback;


use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;

class FeedbackBuilder
{

    public $feedback = [];
    public $questionAssignments;
    /**
     * @var IStudentRepository
     */
    private $studentRepository;
    /**
     * @var IQuestionAssignmentRepository
     */
    private $questionAssignmentRepository;

    protected $students;
    /**
     * @var IElementAssignmentRepository
     */
    private $elementAssignmentRepository;
    /**
     * @var IQuestionScoreRepository
     */
    private $questionScoreRepository;
    /**
     * @var IElementScoreRepository
     */
    private $elementScoreRepository;
    /**
     * @var ICommentRepository
     */
    private $commentRepository;

    public function __construct(
        IQuestionAssignmentRepository $questionAssignmentRepository,
        IElementAssignmentRepository $elementAssignmentRepository,
        IQuestionScoreRepository $questionScoreRepository,
        IElementScoreRepository $elementScoreRepository,
    ICommentRepository $commentRepository
    )
    {


        $this->questionAssignmentRepository = $questionAssignmentRepository;
        $this->elementAssignmentRepository = $elementAssignmentRepository;
        $this->questionScoreRepository = $questionScoreRepository;
        $this->elementScoreRepository = $elementScoreRepository;
        $this->commentRepository = $commentRepository;
    }

    public function loadStudents(IStudentRepository $studentRepository, $examId)
    {
        $this->studentRepository = $studentRepository;
        $this->students = $this->studentRepository->load_students_by_exam($examId);
    }

    /**
     * Creates the feedback structure
     */
    public function buildFeedback($examId)
    {
        $this->loadStudents($examId);
        $this->questionAssignments = $this->questionAssignmentRepository->load_all_for_exam($examId);


        foreach($this->students as $student)
        {
            $accessKey = 'randomnumber here';
            $data =[];
            foreach ($this->questionAssignments as $questionAssignment)
            {
                $questionTitle = $questionAssignment->question->question_name;
                $questionNumber = $questionAssignment->question_number;

                $comments = [];
                $elementAssignments = $this->elementAssignmentRepository->load_element_assignments_by_question_number($examId,
                    $questionNumber);
                foreach($elementAssignments as $elementAssignment)
                {
                    $score = $this->elementScoreRepository->load($elementAssignment->id, $student->id);
                    $comments[$elementAssignment->subtask] =
                        [
                            'subtask' => $elementAssignment->subtask,
                            'score' => $score,
                            'comment' => $this->commentRepository->getCommentForScore($elementAssignment->element->id, $score)
                        ];
                }
                $data[$questionNumber] = [
                    'questionTitle' => $questionTitle,
                    'questionNumber' => $questionNumber,
                    'comments' => $comments
                ];
            }

            $this->feedback[$accessKey] = $data;
        }
        return $this->feedback;
    }

    /**
     * Builds an array of feedback for a single student on the exam
     */
    public function buildStudent($examName, $grade, $questionsArray)
    {

        $this->buildTopLevelContent($studentArray, $examName, $grade);
        foreach($questionsArray as $q){
            $this->buildQuestion($studentArray, $q['questionNumber'], $q['questionTitle'], $q['commentsArray']);
        }

    }


    /**
     * Adds data to the outermost area of a student's array
     * @param $studentArray
     * @param $examName
     * @param $grade
     */
    public function buildTopLevelContent(&$studentArray, $examName, $grade)
    {
        $studentArray['examName'] = $examName;
        $studentArray['grade'] = $grade;
    }


    /**
     * Adds an entry for a question to the studentArray
     * @param $studentArray
     * @param $questionNumber
     * @param $questionTitle
     * @param $commentsArray
     * @return mixed
     */
    public function buildQuestion(&$studentArray, $questionNumber, $questionTitle, $commentsArray)
    {
        $studentArray["question_{$questionNumber}"] =
            [
                'questionTitle' => $questionTitle,
                'comments' => $commentsArray
            ];
        return $studentArray;
    }



}
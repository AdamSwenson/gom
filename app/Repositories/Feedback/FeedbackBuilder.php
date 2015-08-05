<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 5:55 PM
 */

namespace App\Repositories\Feedback;


use App\Feedback;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Feedback\IPseudoIDMaker;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;

class FeedbackBuilder implements IFeedbackBuilder
{

    public $feedback = [];
    public $questionAssignments;

    public $students;

    protected $pseudoIdMaker;
    protected $accessKeyRepository;
    /**
     * @var IStudentRepository
     */
    private $studentRepository;
    /**
     * @var IQuestionAssignmentRepository
     */
    public $questionAssignmentRepository;


    /**
     * @var IElementAssignmentRepository
     */
    public $elementAssignmentRepository;
    /**
     * @var IQuestionScoreRepository
     */
    public $questionScoreRepository;
    /**
     * @var IElementScoreRepository
     */
    public $elementScoreRepository;
    /**
     * @var ICommentRepository
     */
    public $commentRepository;

    public $assignments = array();

    /**
     *
     */
    public function __construct()
    {
        $this->questionAssignmentRepository = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentRepository = app()->make('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreRepository = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreRepository = app()->make('App\Repositories\Score\IElementScoreRepository');
        $this->commentRepository = app()->make('App\Repositories\Element\ICommentRepository');
        $this->studentRepository = app()->make('App\Repositories\Student\IStudentRepository');
        $this->accessKeyRepository = app()->make('App\Repositories\Feedback\IAccessKeyRepository');

//        $this->pseudoIdMaker = app()->make('App\Repositories\Feedback\IPseudoIDMaker');
    }

    /**
     * This stores the question and element assignments in self::assignments so that
     * they can be iterated through for multiple students.
     * @param integer $examId
     */
    public function loadAssignments($examId)
    {
        $this->questionAssignments = $this->questionAssignmentRepository->load_all_for_exam($examId);
        foreach ($this->questionAssignments as $qa)
        {
            $elementAssignments = $this->elementAssignmentRepository->load_element_assignments_by_question_number($examId,
                $qa->getQuestionNumber());
            $elements = [];
            foreach ($elementAssignments as $ea)
            {
                $elements[$ea->getSubtask()] = [
                    'questionNumber' => $ea->getQuestionNumber(),
                    'subtask' => $ea->getSubtask(),
                    'elementId' => $ea->getElementId(),
                    'elementAssignmentId' => $ea->getElementAssignmentId(),
                    'elementName' => $ea->getElementName()
                ];
            }
            $data = [
                'questionNumber' => $qa->getQuestionNumber(),
                'questionId' => $qa->getQuestionId(),
                'questionName' => $qa->getQuestionName(),
                'questionAssignmentId' => $qa->getQuestionAssignmentId(),
                'elements' => $elements
            ];

//            $examName = 'testName';
//            $grade = 'testGrade';
//
//            $outer = [
//                'examName' => $examName,
//                'grade' => $grade,
//                'questions' => $data
//            ];

            array_push($this->assignments, $data);
        }
    }


    /**
     * Populates self::students with the students associated with the exam
     * @param $examId
     */
    public function loadStudents($examId)
    {
        $this->students = $this->studentRepository->load_students_by_exam($examId);
    }



    /**
     * Creates the feedback structure
     * This is the main publicly called method
     */
    public function buildFeedback($examId)
    {
        //Create one master array with all the questions and elements
        if (empty($this->assignments))
        {
            $this->loadAssignments($examId);
        }

        //Get all students who are associated with the exam
        $this->loadStudents($examId);

        foreach ($this->students as $student)
        {
            //Copy the assignments array for the present student
            $studentScores = &$this->assignments;

            //todo Set up grade assignment
//            $studentScores['grade'] = "F-";

            //Iterate through the new copy and add scores and comment content
            foreach ($studentScores as &$question)
            {
                $questionScoreObject = $this->questionScoreRepository->load($question['questionAssignmentId'],
                    $student->id);

                if (!empty($questionScoreObject))
                {
                    $question['score'] = $questionScoreObject->getScore();
                    $question['average'] = 5.0;
                }
                foreach ($question['elements'] as &$element)
                {
                    $scoreObject = $this->elementScoreRepository->load($element['elementAssignmentId'], $student->id);
                    if (!empty($scoreObject) && !empty($scoreObject->score))
                    {
                        $element['score'] = $scoreObject->getScore();
                        $element['average'] = 5.0;
                        $commentObj = $this->commentRepository->getCommentForScore($element['elementId'],
                            $element['score']);
                        $element['comment'] = $commentObj->getBody();
                    }
                }
            }

            $accessKey = $this->accessKeyRepository->createAccessKey($examId, $student->id);

            $this->feedback[$accessKey] = $studentScores;
            $this->storeFeedback($accessKey, $studentScores);
        }

        return $this->feedback;
    }

    /**
     * Saves the content to the database.
     *
     * TODO: Mark as protected once testing is better set up
     *
     * @param $accessKey
     * @param $content
     * @return bool
     */
    public function storeFeedback($accessKey, $content)
    {
        $feedback = new Feedback();
        $feedback->setAccessKey($accessKey);
        $feedback->content = $content;
//        $feedback->setContent($content);
        return $feedback->save();
    }

//
//    public
//    function buildOneQuestion(
//        IElementAssignmentRepository $elementAssignmentRepository,
//        $examId,
//        $questionName,
//        $questionNumber,
//        $studentId,
//        &$data
//    ) {
////        $questionTitle = $questionAssignment->question->question_name;
////        $questionNumber = $questionAssignment->question_number;
//        $comments = [];
//
//        $elementAssignments = $elementAssignmentRepository->load_element_assignments_by_question_number($examId,
//            $questionNumber);
//        $this->buildElementScore($elementAssignments, $studentId, $comments);
//        $data[$questionNumber] = [
//            'questionTitle' => $questionName,
//            'questionNumber' => $questionNumber,
//            'comments' => $comments
//        ];
//    }
//
//
//    /**
//     * Builds an array of feedback for a single student on the exam
//     */
//    public
//    function buildStudent(
//        $examName,
//        $grade,
//        $questionsArray
//    ) {
//
//        $this->buildTopLevelContent($studentArray, $examName, $grade);
//        foreach ($questionsArray as $q)
//        {
//            $this->buildQuestion($studentArray, $q['questionNumber'], $q['questionTitle'], $q['commentsArray']);
//        }
//
//    }
//
//
//    /**
//     * Adds data to the outermost area of a student's array
//     * @param $studentArray
//     * @param $examName
//     * @param $grade
//     */
//    public
//    function buildTopLevelContent(
//        &$studentArray,
//        $examName,
//        $grade
//    ) {
//        $studentArray['examName'] = $examName;
//        $studentArray['grade'] = $grade;
//    }
//
//
//    /**
//     * Adds an entry for a question to the studentArray
//     * @param $studentArray
//     * @param $questionNumber
//     * @param $questionTitle
//     * @param $commentsArray
//     * @return mixed
//     */
//    public
//    function buildQuestion(
//        &$studentArray,
//        $questionNumber,
//        $questionTitle,
//        $commentsArray
//    ) {
//        $studentArray["question_{$questionNumber}"] =
//            [
//                'questionTitle' => $questionTitle,
//                'comments' => $commentsArray
//            ];
//
//        return $studentArray;
//    }
//
//    /**
//     * @param $elementAssignments
//     * @param $student
//     * @param $comments
//     */
//    public
//    function buildElementScore(
//        $elementAssignments,
//        $studentId,
//        &$comments
//    ) {
//        foreach ($elementAssignments as $elementAssignment)
//        {
//            $score = $this->elementScoreRepository->load($elementAssignment->id, $studentId);
//            $comments[$elementAssignment->subtask] =
//                [
//                    'subtask' => $elementAssignment->subtask,
//                    'score' => $score,
//                    'comment' => $this->commentRepository->getCommentForScore($elementAssignment->element->id,
//                        $score)
//                ];
//        }
//    }


}
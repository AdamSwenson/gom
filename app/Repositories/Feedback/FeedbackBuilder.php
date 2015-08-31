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
use App\Student;

class FeedbackBuilder implements IFeedbackBuilder
{
    # ------- repositories
    /** @var IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var IStudentRepository */
    private $studentRepository;

    /** @var IQuestionAssignmentRepository */
    public $questionAssignmentRepository;

    /** @var IElementAssignmentRepository */
    public $elementAssignmentRepository;

    /** @var IQuestionScoreRepository */
    public $questionScoreRepository;

    /** @var IElementScoreRepository */
    public $elementScoreRepository;

    /** @var ICommentRepository */
    public $commentRepository;

    #-------- data holders
    /** @var array Will hold all the question and element assignments for the exam */
    public $assignments = array();

    /** @var array Will hold the feedback assembled for a student */
    public $feedback = [];

    /** @var  Collection The question assignments for the exam */
    public $questionAssignments;

    /** @var  Collection Will hold all of the students for whom feedback is assembled */
    public $students;

    public function __construct()
    {
        $this->questionAssignmentRepository = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentRepository = app()->make('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreRepository = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreRepository = app()->make('App\Repositories\Score\IElementScoreRepository');
        $this->commentRepository = app()->make('App\Repositories\Element\ICommentRepository');
        $this->studentRepository = app()->make('App\Repositories\Student\IStudentRepository');
        $this->accessKeyRepository = app()->make('App\Repositories\Feedback\IAccessKeyRepository');
    }

    /**
     * This stores the question and element assignments in self::assignments so that
     * they can be iterated through for multiple students.
     *
     * Note, will only run if the assignments array is empty.
     *
     * @param integer $examId
     * @param bool $forceReRun Whether to run again
     */
    public function loadAssignments($examId, $forceReRun = false)
    {
        if (empty($this->assignments) || ($forceReRun === true))
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

                array_push($this->assignments, $data);
            }
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
     * Creates the feedback structure for all students taking the exam
     * This is the main publicly called method
     * @param int $examId
     * @return array
     */
    public function buildFeedback($examId)
    {
        //Create one master array with all the questions and elements
        //it will check whether it has already been run
        $this->loadAssignments($examId);

        //Get all students who are associated with the exam
        $this->loadStudents($examId);

        foreach ($this->students as $student)
        {
            //Compile the feedback
            $studentFeedback = $this->compileFeedbackForStudent($student);

            //Create a unique hash to access the feedback
            $accessKey = $this->accessKeyRepository->createAccessKey($examId, $student->id);

            //Store the feedback in our array with the unique hash as key
            $this->feedback[$accessKey] = $studentFeedback;

            //Save the feedback and key to the database
            $this->storeFeedback($accessKey, $studentFeedback);
        }

        return $this->feedback;
    }


    /**
     * Does the work of compiling the feedback for a single student.
     * This does not create the access key or save the feedback to the database.
     *
     * @param Student $student
     * @return array
     */
    protected function compileFeedbackForStudent(Student $student)
    {
        //Copy the assignments array for the present student
        $studentScores = &$this->assignments;

        //todo Set up grade assignment
//            $studentScores['grade'] = "F-";

        //Iterate through the new copy and add scores and comment content
        foreach ($studentScores as &$question)
        {
            //Load question scores for the student
            $questionScoreObject = $this->questionScoreRepository->load($question['questionAssignmentId'], $student->id);

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
                    $element['comment'] = $scoreObject->comment_text;

                    //old way
//                        $commentObj = $this->commentRepository->getCommentForScore($element['elementId'],
//                            $element['score']);
//                        $element['comment'] = $commentObj->getBody();
                }
            }
        }
        
        return $studentScores;
    }

    /**
     * Run the compilation process for a single student and replace the existing
     * feedback in the db with the results (and keep the same access key)
     *
     * @param $examId
     * @param Student $student
     * @return boolean
     */
    public function recompileFeedbackForStudent($examId, Student $student)
    {
        //Create one master array with all the questions and elements
        //it will check whether it has already been run
        $this->loadAssignments($examId);

        //Compile the feedback
        $studentFeedback = $this->compileFeedbackForStudent($student);

        //Load the already existing access key (important since student might have already received it)
        $accessKey = $this->accessKeyRepository->getAccessKeyForStudent($examId, $student->id);

        //Update the db record
        $this->storeFeedback($accessKey, $studentFeedback);

        //Store the feedback in our array with the unique hash as key
        $this->feedback[$accessKey] = $studentFeedback;

        return $this->feedback;
    }

    /**
     * Saves or updates the feedback content to the database.
     *
     * @param string $accessKey
     * @param array $content
     * @return bool
     */
    public function storeFeedback($accessKey, $content)
    {
        $feedback = Feedback::firstOrNew(['access_key' => $accessKey]);
        $feedback->content = $content;
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
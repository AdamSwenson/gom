<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 5:55 PM
 */

namespace App\Repositories\Feedback;


use App\Exam;
use App\Feedback;
use App\Repositories\Element\ICommentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Feedback\IPseudoIDMaker;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Score\ScoreStatisticsRepository;
use App\Repositories\Student\IStudentRepository;
use App\Student;

/**
 * Does all the work of compiling the feedback.
 * Usually called by a queuable job.
 * @package App\Repositories\Feedback
 */
class FeedbackBuilder implements IFeedbackBuilder
{
    # ------- repositories

    /** @var IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var ICommentRepository */
    protected $commentRepository;

    /** @var IElementAssignmentRepository */
    protected $elementAssignmentRepository;

    /** @var IElementScoreRepository */
    protected $elementScoreRepository;

    /** @var IQuestionAssignmentRepository */
    protected $questionAssignmentRepository;

    /** @var IQuestionScoreRepository */
    protected $questionScoreRepository;

    /** @var IScoreStatsRepository */
    protected $scoreStatsRepository;

    /** @var IStudentRepository */
    protected $studentRepository;

    /** @var IStudentGradeRepository */
    protected $studentGradeRepository;


    #-------- data holders
    /** @var  Exam */
    public $exam;

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
        $this->studentGradeRepository = app()->make('App\Repositories\Grade\IStudentGradeRepository');
        $this->scoreStatsRepository = app()->make('App\Repositories\Score\IScoreStatisticsRepository');
    }


    /**
     * Creates the feedback structure for all students taking the exam.
     * Will create new access keys if none already exist. If there are already
     * access keys, it will update the associated content (but not create new keys).
     *
     * TODO: make sure skips if there are no scores
     *
     * This is the main publicly called method
     *
     * @param int $examId
     * @return array
     */
    public function buildFeedback($examId)
    {
        $this->exam = Exam::find($examId);
        
        //Check whether the exam has been graded. 
        //If not, bailout before doing anything else
        if( ! $this->exam->isGraded()){
            
        }

        //Load statistical information
        $this->scoreStatsRepository->loadStats($this->exam);

        //Create one master array with all the questions and elements
        //it will check whether it has already been run
        $this->loadAssignments($examId);

        //Get all students who are associated with the exam
        $this->loadStudents($examId);

        foreach ( $this->students as $student )
        {
            //Compile the feedback
            $studentFeedback = $this->compileFeedbackForStudent($student);

            //Create a unique hash to access the feedback
            $accessKey = $this->accessKeyRepository->createAccessKey($examId, $student->id);

            //Store the feedback in our array with the unique hash as key
            $this->feedback[ $accessKey ] = $studentFeedback;

            //Retrieve and add the student's grade
            $grade = $this->studentGradeRepository->getStudentGrade($this->exam, $student);
            if ( ! empty($grade) )
            {
                $gradeDisplay = $grade->getDisplayValue();
                $gradeCalc = $grade->getCalcValue();

                //Save the feedback and key to the database
                $this->storeFeedback($accessKey, $studentFeedback, $gradeDisplay, $gradeCalc);
            } else
            {
                //No grade loaded. So just save the feedback and key to the database
                $this->storeFeedback($accessKey, $studentFeedback);
            }
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

        //Iterate through the new copy and add scores and comment content
        foreach ( $studentScores as &$question )
        {
            //Load question scores for the student
            $questionScoreObject = $this->questionScoreRepository->load($question['questionAssignmentId'], $student->id);

            if ( ! empty($questionScoreObject) )
            {
                $question['score'] = $questionScoreObject->getScore();
                $question['average'] = $this->scoreStatsRepository->getQuestionAssignmentMean($question['questionAssignmentId']);
            }
            foreach ( $question['elements'] as &$element )
            {
                $scoreObject = $this->elementScoreRepository->load($element['elementAssignmentId'], $student->id);
                if ( ! empty($scoreObject) && ! empty($scoreObject->score) )
                {
                    $element['score'] = $scoreObject->getScore();
                    $element['average'] = $this->scoreStatsRepository->getElementAssignmentMean($element['elementAssignmentId']);
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
     * This is the other main publicly called method
     *
     * @param integer $examId
     * @param Student $student
     * @return array
     */
    public function recompileFeedbackForStudent($examId, Student $student)
    {
        $this->exam = Exam::findOrFail($examId);

        //Create one master array with all the questions and elements
        //it will check whether it has already been run
        $this->loadAssignments($examId);

        //Load statistical information
        $this->scoreStatsRepository->loadStats($this->exam);

        //Compile the feedback
        $studentFeedback = $this->compileFeedbackForStudent($student);

        //Load the already existing access key (important since student might have already received it)
        $accessKey = $this->accessKeyRepository->getAccessKeyForStudent($examId, $student->id);

        /* If we got here before the main feedback compilation is called, accessKey may be empty.
         * So, if that's the case, we need to make one
         */
        if ( empty($accessKey) )
        {
            //Create a unique hash to access the feedback
            $accessKey = $this->accessKeyRepository->createAccessKey($examId, $student->id);
        }

        //Retrieve and add the student's grade
        $grade = $this->studentGradeRepository->getStudentGrade($this->exam, $student);
        if ( ! empty($grade) )
        {
            $gradeDisplay = $grade->getDisplayValue();
            $gradeCalc = $grade->getCalcValue();

            //Update the db record
            $this->storeFeedback($accessKey, $studentFeedback, $gradeDisplay, $gradeCalc);
        } else
        {
            //No grade loaded. So just update the feedback and key to the database
            $this->storeFeedback($accessKey, $studentFeedback);
        }

        //Store the feedback in our array with the unique hash as key
        $this->feedback[ $accessKey ] = $studentFeedback;

        return $this->feedback;
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
        if ( empty($this->assignments) || ($forceReRun === true) )
        {
            $this->questionAssignments = $this->questionAssignmentRepository->load_all_for_exam($examId);
            foreach ( $this->questionAssignments as $qa )
            {
                $elementAssignments = $this->elementAssignmentRepository->load_element_assignments_by_question_number($examId,
                                                                                                                      $qa->getQuestionNumber());
                $elements = [];
                foreach ( $elementAssignments as $ea )
                {
                    $elements[ $ea->getSubtask() ] = [
                        'questionNumber'      => $ea->getQuestionNumber(),
                        'subtask'             => $ea->getSubtask(),
                        'elementId'           => $ea->getElementId(),
                        'elementAssignmentId' => $ea->getElementAssignmentId(),
                        'elementName'         => $ea->getElementName(),
                    ];
                }
                $data = [
                    'questionNumber'       => $qa->getQuestionNumber(),
                    'questionId'           => $qa->getQuestionId(),
                    'questionName'         => $qa->getQuestionName(),
                    'questionAssignmentId' => $qa->getQuestionAssignmentId(),
                    'elements'             => $elements,
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


    protected function getStudentGrade(Student $student, &$studentScores)
    {
        $grade = $this->studentGradeRepository->getStudentGrade($this->exam, $student);
        if ( ! empty($grade) )
        {
            $studentScores['grade'] = $grade->getDisplayValue();
            $studentScores['gradeCalc'] = $grade->getCalcValue();
        }
    }

    /**
     * Saves or updates the feedback content to the database.
     *
     * @param string $accessKey
     * @param array $content
     * @param null $gradeDisplay
     * @param null $gradeCalc
     * @return bool
     */
    public function storeFeedback($accessKey, $content, $gradeDisplay = null, $gradeCalc = null)
    {
        $feedback = Feedback::firstOrNew(['access_key' => $accessKey]);
        $feedback->content = $content;
        $feedback->grade_display = $gradeDisplay;
        $feedback->grade_calc = $gradeCalc;

        return $feedback->save();
    }

}
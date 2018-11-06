<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/4/18
 * Time: 4:02 PM
 */

namespace App\Repositories\Feedback;


use App\Exam;
use App\Feedback;
use App\Models\NewGom\ItemScore;
use App\Repositories\Assignment\IAssignmentRepository;
use App\Repositories\Grade\StudentGradeRepositoryNew;
use App\Repositories\Item\IItemScoreStatisticsRepository;
use App\Repositories\Score\ITotalScoreRepository;
use App\Student;

class NewFeedbackRepository implements INewFeedbackRepository
{
    public $studentGradeRepository;
    public $totalScoreRepository;
    public $feedbackBuilder;
    public $accessKeyRepository;
    /**
     * @var IAssignmentRepository
     */
    private $assignmentRepository;
    /**
     * @var IItemScoreStatisticsRepository
     */
    private $scoreStatisticsRepository;

    /**
     * NewFeedbackRepository constructor.
     * @param ITotalScoreRepository $totalScoreRepository
     * @param IAssignmentRepository $assignmentRepository
     * @param IAccessKeyRepository $accessKeyRepository
     * @param IItemScoreStatisticsRepository $scoreStatisticsRepository
     */
    public function __construct( ITotalScoreRepository $totalScoreRepository, IAssignmentRepository $assignmentRepository, IAccessKeyRepository $accessKeyRepository, IItemScoreStatisticsRepository $scoreStatisticsRepository )
    {
        $this->accessKeyRepository = $accessKeyRepository;
//
        $this->studentGradeRepository = new StudentGradeRepositoryNew();
        $this->totalScoreRepository = $totalScoreRepository;
        $this->assignmentRepository = $assignmentRepository;
        $this->scoreStatisticsRepository = $scoreStatisticsRepository;
    }


    /**
     * Creates the data array that will be used to display feedback.
     * The returned array should contain all info required by the
     * feedback page.
     *
     * @param Exam $exam
     * @param Student $student
     * @return array
     */
    public function buildDataOutput( Exam $exam, Student $student )
    {
        $out = [];
        $out['examId'] = $exam->id;
        $out['exam'] = $exam->toJson();
        $out['student'] = $student->toJson();

        //overall score and grade
        $gradeAssignment = $this->studentGradeRepository->getStudentGrade($exam, $student);
        $out['letterGrade'] = $gradeAssignment ? $gradeAssignment->getDisplayValue() : 0;
        $out['totalScore'] = $this->studentGradeRepository->calculateTotalScoreForStudent($exam, $student);

        //average total score
        $scores = $this->totalScoreRepository->getTotalScoresForExam($exam);
        $out['avgTotalScore'] = $scores->average();

        //add individual item scores
        $out['scores'] = ItemScore::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->get();

        //add item score stats

        $out['itemStats'] = [];
        foreach($out['scores'] as $scoreObj){
            $item = $scoreObj->item()->first();
            $out['itemStats'][$item->id] = $this->scoreStatisticsRepository->getDescriptiveStats($item, $exam);
        }

        //Item and item order data
        //This adds the keys
        //  'itemObjects'
        //  'itemOrder'
        $out += $this->assignmentRepository->getItemOrderForClient($exam);

        return $out;
    }


    /**
     * Creates feedback for a student on the exam and stores with access key.
     * Will create new access key if none already exist.
     * If access key exists, it will update the associated content (but not create new keys).
     *
     * TODO: make sure skips if there are no scores
     *
     * This is the main publicly called method
     *
     * @param Exam $exam
     * @param Student $student
     * @return void
     */
    public function buildFeedback( Exam $exam, Student $student )
    {
        $studentFeedback = $this->buildDataOutput($exam, $student);

        //Create a unique hash to access the feedback
        $accessKey = $this->accessKeyRepository->createAccessKey($exam->id, $student->id);

        //Store the feedback
        $this->storeFeedback($accessKey, $studentFeedback);
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
    public function storeFeedback( $accessKey, $content, $gradeDisplay = null, $gradeCalc = null )
    {
        $feedback = Feedback::where('access_key', $accessKey)->first();
        if ( !$feedback ) {
            $feedback = new Feedback();
            $feedback->access_key = $accessKey;
            $feedback->save();
        }
        $feedback->content = $content;
        $feedback->grade_display = $gradeDisplay;
        $feedback->grade_calc = $gradeCalc;

        return $feedback->save();
    }


}
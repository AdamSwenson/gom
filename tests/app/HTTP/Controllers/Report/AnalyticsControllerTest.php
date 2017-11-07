<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/6/16
 * Time: 4:25 PM
 */

namespace App\HTTP\Controllers\Report;



use App\AccessKey;
use App\Exam;
use App\Feedback;
use App\GradingTime;
use App\Jobs\Feedback\BuildFeedbackAllStudents;
use App\Jobs\Feedback\BuildFeedbackOneStudent;
use App\Jobs\Feedback\NotifyAllStudents;
use App\Jobs\Feedback\NotifySingleStudent;
use App\QuestionScore;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Score\IScoreStatisticsRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingStatsRepository;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class AnalyticsControllerTest extends \TestCase
{

   // use WithoutMiddleware;

    public $student;
    public $exam;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        \Auth::loginUsingId(1);
        $this->exam = Exam::all()->first();
//        $this->exam1 = factory(Exam::class)->create();
        $this->exam->save();

        $this->student = factory(Student::class)->create();

    }

    /** @test */
    public function showAnalytics()
    {
        $route = "report/{$this->exam->id}/analytics";
        $numberStudents = 5;
        $questions = ['a', 'b', 'c'];
        $scores = factory(QuestionScore::class, $numberStudents)->create();
        $students = factory(Student::class, $numberStudents)->create();
        $studentDao = $this->createMock(IStudentRepository::class);
        $studentDao->shouldReceive('load_students_by_exam')
            ->with($this->exam->id)
            ->once()
            ->andReturn($students);

        $qaDao = $this->createMock(IQuestionAssignmentRepository::class);
        $qaDao->shouldReceive('load_all_for_exam')
            ->with($this->exam->id)
            ->once()
            ->andReturn($questions);

        $questionScoreDao = $this->createMock(IQuestionScoreRepository::class);
        $questionScoreDao->shouldReceive('load_all_for_question_number')
            ->times(count($questions))
            ->andReturn($scores);

        $scoreStatsDao = $this->createMock(IScoreStatisticsRepository::class);
        $scoreStatsDao->shouldReceive('loadStats')
            ->with(\Mockery::type(Exam::class))
            ->once(); //this needs to hold the results internally

        $questionScoreDao->shouldReceive('load_all_for_exam')
            ->with($this->exam->id)
            ->once();

        $elementScoreDao = $this->createMock(IElementScoreRepository::class);
        $elementScoreDao->shouldReceive('load_all_for_exam')->with($this->exam->id)->once();

        #call
        $this->call('GET', $route);
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/6/16
 * Time: 4:32 PM
 */

namespace App\HTTP\Controllers\Quality;

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

class QualityControlControllerTest  extends \TestCase
{
//    use WithoutMiddleware;

    public $student;
    public $exam;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->student = factory(Student::class)->create();

    }

    /** @test */
    public function index()
    {
        #prep
        $route = "report/{$this->exam->id}/qualitycontrol";
        $scoreStatsDao = $this->createMock(IScoreStatisticsRepository::class);
        $scoreStatsDao->shouldReceive('getScoresAndTimesByGradedOrder')
            ->once()
            ->with(\Mockery::type(Exam::class))
            ->andReturn(collect(['dummy', 'dummy']));

        $gradingTimeStatsDao = $this->createMock(IGradingStatsRepository::class);
        $gradingTimeStatsDao->shouldReceive('get_grading_time_stats')
            ->once()
            ->with($this->exam->id)->andReturn(factory(GradingTime::class, 5)->make());

        #call
        $this->call('GET', $route);
    }

    /** @test */
    public function show(){}

}

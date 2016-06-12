<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 4:19 PM
 */

namespace App\HTTP\Controllers;


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

class ReportControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public $student;
    public $exam;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->student = factory(Student::class)->create();

    }


    public function updateFeedbackForStudent()
    {
        $this->expectsJobs(BuildFeedbackOneStudent::class);


//        $url = action('ReportController@updateFeedbackForStudent');
//        $this->call("GET", $url, [$exam, $student->id]);

    }


    /** @test */
    public function createFeedback()
    {
        $route = "feedback/make/{$this->exam->id}";
        $this->expectsJobs(BuildFeedbackAllStudents::class);

        #call
        $this->call('GET', $route);
    }

    /** @test */
    public function notifyStudent()
    {
        $route = "report/{$this->exam->id}/students/{$this->student->id}";
        $this->expectsJobs(NotifySingleStudent::class);

        #call
        $this->call('POST', $route);
    }

    /** @test */
    public function notifyStudentWhereNoEmail()
    {
        #prep
        $student = factory(Student::class)->create(['email' => '']);
        $route = "report/{$this->exam->id}/students/{$student->id}";
        $this->doesntExpectJobs(NotifySingleStudent::class);

        #call
        $this->call('POST', $route);
    }

    /** @test */
    public function releaseExam()
    {
        #prep
        $examId = $this->exam->id;
        $route = "report/{$this->exam->id}/release";
        $this->expectsJobs(NotifyAllStudents::class);
        $this->assertFalse($this->exam->isReleased(), "Exam starts not released");

        #call
        $this->call("POST", $route);

        #check
        $reloaded = Exam::find($examId);
        $this->assertTrue($reloaded->isReleased(), "Exam was set to released");
    }

    /** @test */
    public function unreleaseExam()
    {
        #prep
        $numberKeys = 3;
        $examId = $this->exam->id;
        $route = "report/{$this->exam->id}/unrelease";
        $keys = factory(AccessKey::class, $numberKeys)->create();
        $this->keyVals = [];
        foreach ( $keys as $k )
        {
            $this->keyVals[] = $k->getKey();
        }
        $validateKey = function ($key)
        {
            if ( in_array($key, $this->keyVals) )
            {
                return true;
            }

            return false;
        };
        $accessKeyDao = $this->createMock(IAccessKeyRepository::class);
        $accessKeyDao->shouldReceive('getAccessKeysForExam')
            ->with($this->exam->id)
            ->once()
            ->andReturn($keys);

        $accessKeyDao->shouldReceive('removeAccessKey')
            ->times($numberKeys);

        #call
        $this->call("POST", $route);

        #check
        $reloaded = Exam::find($examId);
        $this->assertFalse($reloaded->released, "Exam has been marked unreleased");
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


    /** @test */
    public function showExams()
    {
        #prep
        $route = '/report';
        $examDao = $this->createMock(IExamRepository::class);
        $examDao->shouldReceive('load_all_exams')->once()->andReturn(factory(Exam::class, 3)->make());

        #call
        $this->call('GET', $route);
    }

    /** @test */
    public function showQualityControl()
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
    public function showStudentsWhereExamNotReleased(){
        #prep
        $route = "report/{$this->exam->id}/students";
        $numberStudents = 5;
        $students = factory(Student::class, $numberStudents)->create();

        $studentDao = $this->createMock(IStudentRepository::class);
        $studentDao->shouldReceive('load_students_by_exam')
            ->once()
            ->with($this->exam->id)
            ->andReturn($students);

        $feedbackBuilder = $this->createMock(IFeedbackBuilder::class);
        $feedbackBuilder->shouldReceive('buildFeedback')->with($this->exam->id)->once();
        $feedbackBuilder->shouldReceive('recompileFeedbackForStudent')
            ->with($this->exam->id, \Mockery::type(Student::class))
            ->times($numberStudents);

        #call
        $this->call('GET', $route);
    }

    /** @test */
    public function showStudentsWhereExamPreviouslyReleased(){
        #prep
        $exam = factory(Exam::class)->create(['released' => true]);
        $route = "report/{$exam->id}/students";
        $numberStudents = 5;
        $students = factory(Student::class, $numberStudents)->create();

        $studentDao = $this->createMock(IStudentRepository::class);
        $studentDao->shouldReceive('load_students_by_exam')
            ->once()
            ->with($exam->id)
            ->andReturn($students);

        $feedbackBuilder = $this->createMock(IFeedbackBuilder::class);
        $feedbackBuilder->shouldReceive('buildFeedback')->never();
        $feedbackBuilder->shouldReceive('recompileFeedbackForStudent')
            ->with($exam->id, \Mockery::type(Student::class))
            ->times($numberStudents);

        #call
        $this->call('GET', $route);
    }

    /** @test */
    public function showStudentFeedback(){
        #prep
        $route = "report/{$this->exam->id}/students/{$this->student->id}";
        $key = factory(AccessKey::class)->create();

        $accessKeyDao = $this->createMock(IAccessKeyRepository::class);
        $accessKeyDao->shouldReceive('getAccessKeyForStudent')
            ->with($this->exam->id, $this->student->id)
            ->once()
            ->andReturn($key);
        $accessKeyDao->shouldReceive('retrieveFeedback')
            ->once()
            ->with($key)
            ->andReturn(factory(Feedback::class)->make());

        #call
        $this->call("GET", $route);
    }

    /** @test */
    public function showFeedbackForAllStudentsOnExam(){
        #prep
        $route = "report/{$this->exam->id}/feedback/all";
        $numberStudents = 5;
        $students = factory(Student::class, $numberStudents)->create();
        $key = factory(AccessKey::class)->create();

        $studentDao = $this->createMock(IStudentRepository::class);
        $studentDao->shouldReceive('load_students_by_exam')
            ->once()
            ->with(\Mockery::type(Exam::class))
            ->andReturn($students);

        $accessKeyDao = $this->createMock(IAccessKeyRepository::class);
        $accessKeyDao->shouldReceive('getAccessKeyForStudent')
            ->times($numberStudents)
            //->with($this->exam->id, $this->student->id)
            ->andReturn($key);

        $accessKeyDao->shouldReceive('retrieveFeedback')
            ->times($numberStudents)
            ->with($key)
            ->andReturn(factory(Feedback::class)->make());

        #call
        $this->call("GET", $route);
    }
}

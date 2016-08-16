<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 2:21 PM
 */

namespace App\Jobs\Feedback;


use App\Exam;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Utilities\IMailSender;
use App\Student;

class NotifyStudentsHelperTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }


    /**
     * Prepares the expected subject line for the notification email
     * @param $exam
     * @return string
     */
    protected function buildSubject($exam)
    {
        return "Your feedback for " . $exam->getName();
    }

    /**
     * Prepares expected link.
     * We don't just use the object's method because we want to know
     * if this link ever gets changed accidentally.
     * @param $accessKey
     * @return string
     */
    protected function buildFeedbackLink($accessKey)
    {
        return 'https://www.gradeomatic.net/feedback?accessKey=' . $accessKey;
    }

    /**
     * Builds the expected link for inclusion in the email.
     * We don't rely on the object class for this because we want to know if the
     * object class gets changed without the test being explicitly updated.
     * @return string
     */
    protected function buildSiteLink(){
        return 'https://www.gradeomatic.net/feedback/login';
    }
    

    /** @test */
    public function sendEmailToStudentInitialView()
    {
        #prep
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();
        $accessKey = $this->faker->sha1();
        $view = NotifyStudentsHelper::INITIAL_EMAIL_VIEW;
        $data =[
            'studentName' => $student->getFullName(),
            'examName' => $exam->getName(),
            'feedbackLink' => $this->buildFeedbackLink($accessKey),
            'siteLink' => $this->buildSiteLink(),
            'accessKey' => $accessKey
            ];
        
        $mock = $this->createMock(IAccessKeyRepository::class);
        $mock->shouldReceive('getAccessKeyForStudent') 
            ->once()
            ->with($exam->id, $student->id)
            ->andReturn($accessKey);

        $mailer = $this->createMock(IMailSender::class);
        $mailer->shouldReceive('send')
            ->once()
            ->with($student->email, $student->getFullName(), $data, $view, $this->buildSubject($exam));

        #call
        $object = new NotifyStudentsHelper;
        $object->sendEmailToStudent($exam, $student, true);
    }

    /** @test */
    public function sendEmailToStudentSecondaryView(){
        #prep
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();
        $accessKey = $this->faker->sha1();
        $view = NotifyStudentsHelper::SECOND_EMAIL_VIEW;
        $data =[
            'studentName' => $student->getFullName(),
            'examName' => $exam->getName(),
            'feedbackLink' => $this->buildFeedbackLink($accessKey),
            'siteLink' => $this->buildSiteLink(),
            'accessKey' => $accessKey
        ];

        $mock = $this->createMock(IAccessKeyRepository::class);
        $mock->shouldReceive('getAccessKeyForStudent')
            ->once()
            ->with($exam->id, $student->id)
            ->andReturn($accessKey);

        $mailer = $this->createMock(IMailSender::class);
        $mailer->shouldReceive('send')->once()
            ->with($student->email, $student->getFullName(), $data, $view, $this->buildSubject($exam));

        #call
        $object = new NotifyStudentsHelper;
        $object->sendEmailToStudent($exam, $student, false);
    }


    /** @test */
    public function sendEmailToStudentNoAccessKeyFound(){
        #prep
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();

        $mock = $this->createMock(IAccessKeyRepository::class);
        $mock->shouldReceive('getAccessKeyForStudent')
            ->once()
            ->with($exam->id, $student->id)
            ->andReturn(false);

        $mailer = $this->createMock(IMailSender::class);
        $mailer->shouldReceive('send')
            ->never();

        #call
        $object = new NotifyStudentsHelper;
        $object->sendEmailToStudent($exam, $student);
    }


    /** @test */
    public function sendEmailToAllGradedStudents()
    {
        #prep
        $numberStudents = 5;
        $exam = factory(Exam::class)->create();
        $students = factory(Student::class, 5)->create();
        $accessKey = $this->faker->sha1();
        $view = NotifyStudentsHelper::INITIAL_EMAIL_VIEW;

        $studentDao = $this->createMock(IStudentRepository::class);
        $studentDao->shouldReceive('load_students_by_exam')
            ->once()
            ->with($exam)
            ->andReturn($students);

        $accessKeyDao = $this->createMock(IAccessKeyRepository::class);
        $mailer = $this->createMock(IMailSender::class);

        $accessKeyDao->shouldReceive('getAccessKeyForStudent')->times($numberStudents)->andReturn($accessKey);
        $mailer->shouldReceive('send')->times($numberStudents);

        #call
        $object = new NotifyStudentsHelper;
        $object->sendEmailToAllGradedStudents($exam);

//foreach($students as $student){
//    $mock->shouldReceive('getAccessKeyForStudent')
//        ->once()
//        ->with($exam->id, $student->id)
//        ->andReturn($accessKey);
//
//    $data =[
//        'studentName' => $student->getFullName(),
//        'examName' => $exam->getName(),
//        'feedbackLink' => $this->buildFeedbackLink($accessKey),
//        'siteLink' => $this->buildSiteLink(),
//        'accessKey' => $accessKey
//    ];
//
//    $mailer->shouldReceive('send')
//        ->once()
//        ->with($student->email, $student->getFullName(), $data, $view, $this->buildSubject($exam));
//
//}


    }

    

    /** @test */
    public function loadAccessKeyHappyPath()
    {
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();
        $accessKey = $this->faker->sha1();

        $mock = $this->createMock(IAccessKeyRepository::class);
        $mock->shouldReceive('getAccessKeyForStudent')
            ->once()
            ->with($exam->id, $student->id)
            ->andReturn($accessKey);

        #call
        $object = new NotifyStudentsHelper;
        $result = $object->loadAccessKey($exam, $student);

        #check
        $this->assertEquals($accessKey, $result);
    }

    /** @test */
    public function loadAccessKeyStudentLacksEmail()
    {
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create(['email' => '']);

        $mock = $this->createMock(IAccessKeyRepository::class);
        $mock->shouldReceive('getAccessKeyForStudent')
            ->never();

        #call
        $object = new NotifyStudentsHelper;
        $result = $object->loadAccessKey($exam, $student);

        #check
        $this->assertEquals(false, $result);
    }
}

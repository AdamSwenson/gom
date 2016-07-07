<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/12/15
 * Time: 6:41 PM
 */

namespace App\Jobs\Feedback;

use App\Exam;
use App\Repositories\Feedback\IAccessKeyRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Utilities\IMailSender;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Does all the work (loads access key, constructs feedback link, looks up email addresses,
 * and sends the message) for any job which notifies students that feedback is ready.
 *
 * @package App\Jobs\Feedback
 */
class NotifyStudentsHelper implements INotifyStudentsHelper
{
    /** The text of the email sent the first time a student is notified */
    const INITIAL_EMAIL_VIEW = 'emails.studentNotification.initial';

    /** The text of the email on any additional notification  */
    const SECOND_EMAIL_VIEW = 'emails.studentNotification.additional';

    /** The route to which the link in the email will direct  */
    const FEEDBACK_PAGE_LINK = 'https://www.gradeomatic.net/feedback';

    /** @var  \App\Repositories\Feedback\IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var \App\Repositories\Student\IStudentRepository */
    protected $studentRepository;

    /** @var  array Holds the students who should receive emails */
    protected $students;

    protected $mailer;


    public function __construct()
    {
        $this->accessKeyRepository = app()->make(IAccessKeyRepository::class);
        $this->studentRepository = app()->make(IStudentRepository::class);
        $this->mailer = app()->make(IMailSender::class);
    }

    /**
     * Prepares and sends a notification email to one student.
     * The $initial parameter governs whether to send the initial email or a re-notification email.
     * @param Exam $exam
     * @param Student $student
     * @param bool|true $initial Whether to send the initial email
     * @return bool
     */
    public function sendEmailToStudent(Exam $exam, Student $student, $initial = true)
    {
        try{
            $accessKey = $this->loadAccessKey($exam, $student);
            if ( ! empty($accessKey) )
            {
                $data = [
                    'studentName'  => $student->getFullName(),
                    'examName'     => $exam->getName(),
                    'feedbackLink' => $this->buildLink($accessKey),
                    'siteLink'     => self::FEEDBACK_PAGE_LINK . '/login',
                    'accessKey'    => $accessKey,
                ];

                //Pick which email to send
                $view = $initial ? self::INITIAL_EMAIL_VIEW : self::SECOND_EMAIL_VIEW;

                //Handle the send
                $this->send($student->email, $student->getFullName(), $data, $view, $this->buildSubject($exam));

                return true;
            }
        } catch ( Exception $e )
        {
//Log failure
            Log::info("Error sending email to student " . $e);

            //TODO Error handling if an access key hasn't already been set
        }

    }


    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded.
     *
     * @param Exam $exam
     * @param bool $initial Whether to use the initial email template
     */
    protected function sendEmailToEveryone(Exam $exam, $initial = true)
    {
        $this->students = $this->studentRepository->load_students_by_exam($exam);
        foreach ( $this->students as $student )
        {
            $this->sendEmailToStudent($exam, $student, $initial);
        }
    }


    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded. Uses database flags to determine which version of the email to send.
     *
     * @param Exam $exam
     */
    public function sendEmailToAllGradedStudents(Exam $exam)
    {
        //TODO check whether already sent, if not
        $initial = true;

        $this->sendEmailToEveryone($exam, $initial);
    }


    /**
     * Constructs the link that the student will click to access feedback
     * @param $accessKey
     * @return string
     */
    protected function buildLink($accessKey)
    {
        return self::FEEDBACK_PAGE_LINK . '?accessKey=' . $accessKey;
    }

    /**
     * Prepares the subject line for the notification email
     * @param $exam
     * @return string
     */
    protected function buildSubject($exam)
    {
        return "Your feedback for " . $exam->getName();
    }

    /**
     * Checks that there is an email address for the student and that
     * the student has feedback compiled.
     *
     * If both are true, then it will return the access key.
     *
     * @param Exam $exam
     * @param Student $student
     * @return bool|string
     */
    public function loadAccessKey(Exam $exam, Student $student)
    {
        if ( ! empty($student->getEmail()) )
        {
            $key = $this->accessKeyRepository->getAccessKeyForStudent($exam->id, $student->id);
            if ( $key )
            {
                return $key;
            }
        }

        return false;
    }

    /**
     * Actually sends the email to the student.
     *
     * @param string $to_address Recipient's email address
     * @param string $to_name Recipient's name
     * @param array $data Data to be passed to the view
     * @param string $emailView Which email text to use
     * @param string $subject Subject line of the email
     */
    protected function send($to_address, $to_name, $data, $emailView, $subject)
    {
        $this->mailer->send($to_address, $to_name, $data, $emailView, $subject);
//        \Mail::send($emailView, $data, function ($message) use ($to_address, $to_name, $subject)
//        {
//            $message->to($to_address, $to_name)->subject($subject);
//        });
    }

    /**
     * NOT YET WORKING
     *
     * Builds a pdf of the student's feedback and mails the pdf
     *
     * @param Exam $exam
     * @param Student $student
     * @return mixed
     */
    public function buildPdf(Exam $exam, Student $student)
    {
//
//        $key = $this->accessKeyRepository->getAccessKeyForStudent($exam->id, $student->id);
//
//        $fb = $this->accessKeyRepository->retrieveFeedback($key);
//
//        $data = $fb->content;
//
//  //      $pdf = \PDF::loadView('feedback.feedback', $data);
//
//        return $pdf;
//        Mail::send($emailView, $data, function($message) use($pdf)
//        {
//            $message->from('us@example.com', 'Your Name');
//
//            $message->to('foo@example.com')->subject('Invoice');
//
//            $message->attachData($pdf->output(), "invoice.pdf");
//        });
    }


}
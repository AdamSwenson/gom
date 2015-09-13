<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/12/15
 * Time: 6:41 PM
 */

namespace App\Jobs\Feedback;

use App\Exam;
use App\Student;
use Illuminate\Support\Facades\Auth;

/**
 * Does all the work for any job which notifies students
 * @package App\Jobs\Feedback
 */
class NotifyStudentsHelper
{

    const INITIAL_EMAIL_VIEW = 'emails.initial_student_notification';
    const SECOND_EMAIL_VIEW = 'emails.additional_student_notification';

    const FEEDBACK_PAGE_LINK = 'http://www.gradeomatic.net/feedback';

    /** @var  \App\Repositories\Feedback\IAccessKeyRepository */
    protected $accessKeyRepository;

    /** @var \App\Repositories\Student\IStudentRepository */
    protected $studentRepository;

    /** @var  array Holds the students who should receive emails */
    protected $students;


    public function __construct()
    {
        $this->accessKeyRepository = app()->make('App\Repositories\Feedback\IAccessKeyRepository');
        $this->studentRepository = app()->make('App\Repositories\Student\IStudentRepository');
    }

    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded. Uses database flags to determine which version of the email to send.
     *
     * @param Exam $exam
     */
    public function sendEmailToAllGradedStudents(Exam $exam)
    {
        //check whether already sent, if not
        $initial = true;

        $this->sendEmailToEveryone($exam, $initial);
    }

    /**
     * Prepares and sends notification email to one student
     * @param Exam $exam
     * @param Student $student
     * @param bool|true $initial
     */
    public function sendEmailToStudent(Exam $exam, Student $student, $initial=true)
    {\error_log('jjjj');
        $accessKey = $this->loadAccessKey($exam, $student);
        if( ! empty($accessKey) )
        {
            $data = [
                'studentName' => $student->getFullName(),
                'examName' => $exam->getName(),
                'feedbackLink' => $this->buildLink($accessKey),
                'siteLink' => self::FEEDBACK_PAGE_LINK,
                'accessKey' => $accessKey
            ];

            $view = $initial ? self::INITIAL_EMAIL_VIEW : self::SECOND_EMAIL_VIEW;

            $this->send($student->email, $student->getFullName(), $data, $view, $this->buildSubject($exam));
        }
    }


    /**
     * Sends a notification email with link to feedback to all students whose exams
     * have been graded.
     *
     * @param Exam $exam
     * @param bool $initial Whether to use the initial email template
     */
    protected function sendEmailToEveryone(Exam $exam, $initial=true)
    {
        $this->students = $this->studentRepository->load_students_by_exam($exam);
        foreach($this->students as $student)
        {
            $this->sendEmailToStudent($exam, $student, $initial);
        }
    }





    /**
     * Updates the db flags to show that the student has had the email sent.
     * Adds entry to the mail log
     *
     * @param Exam $exam
     * @param Student $student
     */
    public function logSent(Exam $exam, Student $student)
    {
        // TODO: Set up mail logging
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
        if(!empty($student->getEmail()))
        {
            $key = $this->accessKeyRepository->getAccessKeyForStudent($exam->id, $student->id);
            if($key)
            {
                return $key;
            }
        }
        return false;
    }

    public function buildPdf(Exam $exam, Student $student)
    {

        $key = $this->accessKeyRepository->getAccessKeyForStudent($exam->id, $student->id);

        $fb = $this->accessKeyRepository->retrieveFeedback($key);

        $data = $fb->content;

        $pdf = \PDF::loadView('feedback.feedback', $data);

        return $pdf;
//        Mail::send($emailView, $data, function($message) use($pdf)
//        {
//            $message->from('us@example.com', 'Your Name');
//
//            $message->to('foo@example.com')->subject('Invoice');
//
//            $message->attachData($pdf->output(), "invoice.pdf");
//        });
    }

    protected function send($to_address, $to_name, $data, $emailView, $subject)
    {
        error_log('sending');

        \Mail::send($emailView, $data, function ($message) use ($to_address, $to_name, $subject)
        {
            $message->to($to_address, $to_name)->subject($subject);
        });
        error_log('sent');
    }
}
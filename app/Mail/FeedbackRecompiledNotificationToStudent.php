<?php

namespace App\Mail;

use App\Exam;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class FeedbackRecompiledNotificationToStudent
 * The message sent to the student when their feedback has been recompiled
 *
 * @package App\Mail
 */
class FeedbackRecompiledNotificationToStudent extends Mailable
{
    use Queueable, SerializesModels;

    /** The text of the email on any additional notification  */
    const EMAIL_VIEW = 'emails.studentNotification.additional';

    /** The route to which the link in the email will direct  */
    const FEEDBACK_PAGE_LINK = 'https://www.gradeomatic.net/feedback';

    /**
     * @var Exam
     */
    public $exam;
    public $data;
    public $student;
    public $studentName;
    public $feedbackLink;
    public $examName;
    public $siteLink;
    public $accessKey;
    public $subjectLine;

    /**
     * Create a new message instance.
     * @param Student $student
     * @param Exam $exam
     * @param $accessKey
     * @internal param $data
     */
    public function __construct(Student $student, Exam $exam, $accessKey)
    {
        $this->accessKey = $accessKey;
        $this->exam = $exam;
        $this->examName = $this->exam->getName();
        $this->feedbackLink = self::FEEDBACK_PAGE_LINK . '?accessKey=' . $accessKey;;
        $this->siteLink = self::FEEDBACK_PAGE_LINK . '/login';
        $this->student = $student;
        $this->studentName = $student->getFullName();
        $this->subjectLine = "Your updated feedback for " . $this->exam->getName();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view(self::EMAIL_VIEW);
    }

}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccessKey
 *
 * This mediates access to the mysql table where access keys are held.
 *
 * That table also holds exam id, user id, and student id, so that a
 * user can look up an id for a student.
 *
 * Student access to the feedback will probably not be mediated through this model
 *
 * @package App
 */
class AccessKey extends BaseModelNoUser
{

    /** The number of random bytes to create for lookup id  */
    const LOOKUP_SIZE = 225;

    const MAX_ATTEMPTS = 10;

    protected $fillable = ['student_id', 'exam_id', 'access_key'];

    protected $casts = [
        'accessKey' => 'string',
        'student_info' => 'array'
    ];

    public function getKey()
    {
        return $this->attributes['access_key'];
    }

    public function setKey($accessKey)
    {
        $this->attributes['access_key'] = $accessKey;
    }

    public function getExamId()
    {
        return $this->attributes['exam_id'];
    }

    public function setExamId($examId)
    {
        $this->attributes['exam_id'] = $examId;
    }

    public function getStudentId()
    {
        return $this->attributes['student_id'];
    }

    public function setStudentId($studentId)
    {
        $this->attributes['student_id'] = $studentId;
    }

    /**
     * Returns the date the student's access to feedback expires
     */
    public function getExpirationDate()
    {
        return Carbon::parse($this->attributes['access_expires']);
    }

    /**
     * Updates the date on which access will expire.
     * Saves to database. Do not need to call update independently.
     * @param $date
     */
    public function setExpirationDate($date)
    {
        $this->attributes['access_expires'] = Carbon::parse($date);
        $this->update();
    }

    /**
     * Returns true if the student has been sent an email with feedback/ link to feedback.
     * @return boolean
     */
    public function getEmailSent()
    {
        return $this->attributes['email_sent'];
    }

    /**
     * Updates the database to indicate that the student has been sent an email with
     * feedback / link to feedback.
     */
    public function markEmailSent()
    {
        $this->attributes['email_sent'] = true;
        $this->update();
    }


    #------------------------------------------ queries
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    #------------------------------------------ foreign keys
//    /**
//     * Junction to user
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function user()
//    {
//        return $this->belongsTo('App\User');
//    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }


}

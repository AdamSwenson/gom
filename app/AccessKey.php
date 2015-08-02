<?php

namespace App;

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
class AccessKey extends BaseModel
{

    /** The number of random bytes to create for lookup id  */
    const LOOKUP_SIZE = 225;

    const MAX_ATTEMPTS = 10;

    protected $fillable = [];

    protected $casts = [
        'accessKey' => 'string'
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

    #------------------------------------------ queries
    public function scopeOnExam($query, $examId)
    {
        return $query->whereExamId($examId);
    }

    #------------------------------------------ foreign keys
    /**
     * Junction to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }


}

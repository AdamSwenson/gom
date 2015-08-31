<?php

namespace App;

use Carbon\Carbon;

/**
 * Class Student
 *
 * A student who will take an exam.
 *
 * Each student can take an exam exactly once.
 *
 * The sid property is a unique integer provided by the user, it is not the same as the id.
 *
 * @package App
 */
class Student extends BaseModel
{
    /** Maximum length in digits of the sid field (used in sanitizing) */
    const MAX_SID_LENGTH = 15;

    /** Maximum length in utf-8 characters of the studentName field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in utf-8 characters of the email field (used in sanitizing) */
    const MAX_EMAIL_LENGTH = 300;

    protected $fillable = [
        'student_identifier',
        'first_name',
        'last_name',
        'email'
    ];

    protected $casts = [
        'student_identifier' => 'integer',
        'last_name' => 'string',
        'first_name' => 'string',
        'email' => 'string'
    ];


    /* Here is a list keys that are available in the atributes array (08/04/15)
     *     'id' , 'user_id' , 'student_identifier' , 'first_name' , 'last_name' , 'email' , 'created_at' , 'updated_at' ,
     *
     *  'pivot'  which contains:
     *        'kumi_id' , 'student_id' , 'created_at' , 'updated_at'
     */



    public function __construct()
    {
        parent::boot();
    }

    /**
     * Returns the identifier that a user has entered for the student. It does
     * not return the database's id for the student. The database id for the
     * student should be accessed via $student->id.
     *
     * @return integer
     */
    public function getStudentId()
    {
        return $this->attributes['student_identifier'];
    }

    /**
     * Sets the user-given identifying number for the student
     * @param integer $studentId
     */
    public function setStudentId($studentId)
    {
        $this->attributes['student_identifier'] = $studentId;
    }


    /**
     * Sets the student's first name
     * NB., does not save the change. So update needs to be independently called.
     * @param string $firstname
     */
    public function setStudentFName($firstname)
    {
        $this->attributes['first_name'] = $firstname;
    }

    /**
     * Returns the student's first name
     * @return string
     */
    public function getStudentFName()
    {
       return $this->attributes['first_name'];
    }

    /**
     * Sets the student's last name
     * NB., does not save the change. So update needs to be independently called.
     * @param string $lastname
     */
    public function setStudentLName($lastname)
    {
        $this->attributes['last_name'] = $lastname;
    }

    /**
     * Returns the student's last name
     * @return string
     */
    public function getStudentLName()
    {
        return $this->attributes['last_name'];
    }

    /**
     * Change email address for student.
     * NB., does not save the change. So update needs to be independently called.
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->attributes['email'] = $email;
    }

    /**
     * Returns the student's email address.
     * @return mixed
     */
    public function getEmail()
    {
       return $this->attributes['email'];
    }
#------------------------- Access to complicated properties

    /**
     * Returns true if the student has been sent an email in order to access their feedback
     * for the specified exam.
     *
     * @param integer $examId
     * @return boolean
     */
    public function feedbackEmailSent($examId)
    {
        $ak = AccessKey::where('exam_id', $examId)->where('student_id', $this->attributes['id'])->first();
        return $ak ? $ak->getEmailSent() : false;
    }

    /**
     * Returns true if their exam has been graded (viz., if there is
     * at least one question score recorded).
     *
     * @param integer $examId
     * @return boolean
     */
    public function hasBeenGraded($examId)
    {

    }

    /**
     * Returns true if feedback has been created and access to the feedback
     * has not expired.
     *
     * @param integer $examId
     * @return bool
     */
    public function isFeedbackAvailable($examId)
    {
        $expirationDate = $this->getFeedbackAccessExpirationDate($examId);
        if(! is_null($expirationDate))
        {
            if(Carbon::now()->lte($expirationDate))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the date feedback will begin no longer being available to the student
     * @param integer $examId
     * @return bool|Carbon
     */
    public function getFeedbackAccessExpirationDate($examId)
    {
        $ak = AccessKey::where('exam_id', $examId)->where('student_id', $this->attributes['id'])->first();
        return $ak ? $ak->getExpirationDate() : false;
    }

#-------- foreign keys

    /**
     * Junction for classes (kumi)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kumis()
    {
        return $this->belongsToMany('App\Kumi', 'kumi_student'); //removed belongsToMany
    }

//    public function exams()
//    {
//        return $this->hasManyThrough('App\Exam', 'App\Kumi');
//    }

    /**
     * Junction with user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

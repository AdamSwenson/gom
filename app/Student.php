<?php

namespace App;

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
        'studentIdentifier',
        'studentName',
        'email'];

    protected $casts = [
        'studentIdentifier' => 'integer',
        'studentName' => 'string',
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

    public function setStudentId($studentId)
    {
        $this->attributes['student_identifier'] = $studentId;
    }

    public function getStudentId()
    {
        return $this->attributes['student_identifier'];
    }



    public function setStudentFName($firstname)
    {
        $this->attributes['first_name'] = $firstname;
    }

    public function getStudentFName()
    {
       return $this->attributes['first_name'];
    }

    public function setStudentLName($lastname)
    {
        $this->attributes['last_name'] = $lastname;
    }

    public function getStudentLName()
    {
        return $this->attributes['last_name'];
    }




    /**
     * Change email address for student
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->attributes['email'] = $email;
    }

    public function getEmail()
    {
       return $this->attributes['email'];
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

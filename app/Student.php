<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

/**
 * Class Student
 * 
 * A student who will take an exam.
 * 
 * Each student can take an exam exactly once.
 * 
 * The sid property is a unique string (usually, but not necessarily, an integer provided by the user, it is not the
 * same as the id.
 * 
 * Here is a list keys that are available in the attributes array (08/04/15)
 *     'id' , 'user_id' , 'student_identifier' , 'first_name' , 'last_name' , 'email' , 'created_at' , 'updated_at' ,
 * 
 *  'pivot'  which contains:
 *        '_id' , 'student_id' , 'created_at' , 'updated_at'
 *
 * @package App
 * @property integer $id
 * @property integer $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $student_identifier
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Kumi[] $kumis
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereStudentIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel loggedIn()
 * @mixin \Eloquent
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
        'email',
    ];

    protected $casts = [
        'student_identifier' => 'integer',
        'last_name'          => 'string',
        'first_name'         => 'string',
        'email'              => 'string',
    ];

    /** @var array Attributes which should be encrypted in the database */
    protected $encryptedAttributes = [
        'student_identifier',
        'email',
    ];


    /**
     * Returns the concatenated first name  and last name
     */
    public function getFullName()
    {
        return $this->getStudentFName() . ' ' . $this->getStudentLName();
    }


//    /**
//     * Returns the student_identifier attribute
//     * Uses laravel convention for getter so will be called if
//     * someone tries to get directly with $student->student_identifier
//     * @return string
//     */
//    public function getStudentIdentifierAttribute()
//    {
//        return $this->attributes['student_identifier'];
////        return $this->getAttribute('student_identifier');
//    }
//
//    /**
//     * Returns the first_name attribute
//     * Uses laravel convention for getter so will be called if
//     * someone tries to get directly with $student->first_name
//     * @return string
//     */
//    public function getFirstNameAttribute()
//    {
//        return $this->attributes['first_name'];
////        return $this->getAttribute('first_name');
//    }
//
//    /**
//     * Returns the last_name attribute
//     * Uses laravel convention for getter so will be called if
//     * someone tries to get directly with $student->
//     * @return string
//     */
//    public function getLastNameAttribute()
//    {
//        return $this->attributes['last_name'];
////        return $this->getAttribute('last_name');
//    }

//    /**
//     * Returns the decrypted student email address
//     * Uses laravel convention for getter so will be called if
//     * someone tries to get directly with $student->email
//     * @return string
//     */
//    public function getEmailAttribute()
//    {
//        return $this->attributes['email'];
////        return $this->getAttribute('email');
//    }

//    /**
//     * Sets student_identifier attribute.
//     * Uses laravel convention for setter so will be called if
//     * someone tries to set directly with $student->student_identifier
//     * @param string $studentId
//     */
//    public function setStudentIdentifierAttribute($studentId)
//    {
//        $studentId = trim($studentId);
//        $this->attributes['student_identifier'] = $studentId;
////        $this->setAttribute('student_identifier', $studentId);
//    }

    /**
     * Sets the first_name attribute
     *
     * Uses laravel convention for setter
     * so will be called if someone tries $student->first_name = first_name
     *
     * @param string $firstName
     */
    public function setFirstNameAttribute($firstName)
    {
        $firstName = trim(ucfirst($firstName));
        $this->attributes['first_name'] = $firstName;
//        $this->setAttribute('first_name', $firstName);
    }

    /**
     * Sets the last_name attribute.
     *
     * Uses laravel convention for setter
     * so will be called if someone tries $student->last_name = last_name
     * @param string $lastName
     */
    public function setLastNameAttribute($lastName)
    {
        $lastName = trim(ucfirst($lastName));
        $this->attributes['last_name'] = $lastName;
//        $this->setAttribute('last_name', $lastName);
    }

    /**
     * Sets email attribute.
     * Uses laravel convention for setter
     * so will be called if someone tries $student->email = email_address
     * @param $email
     */
    public function setEmailAttribute($email)
    {
        $email = trim($email);
        $this->attributes['email'] = $email;
//        $this->setAttribute('email', $email);
    }

    /* ----------------------- Non laravel convention using getters and setters */

    /**
     * Returns the identifier that a user has entered for the student. It does
     * not return the database's id for the student. The database id for the
     * student should be accessed via $student->id.
     * THIS SHOULD ALWAYS BE USED BECAUSE THE ID IS STORED ENCRYPTED.
     *
     * @return integer
     */
    public function getStudentId()
    {
        return $this->getStudentIdentifierAttribute();
//        return $this->getAttribute('student_identifier');
//        return $this->attributes['student_identifier'];
//        if( ! empty($this->attributes['student_identifier']) )
//        {
//            return Crypt::decrypt($this->attributes['student_identifier']);
//        }
//        return null;
    }


    /**
     * Sets the user-given identifying number for the student.
     * Alias for the laravel convention using setter
     * THIS SHOULD ALWAYS BE USED BECAUSE THE ID IS STORED ENCRYPTED.
     * @param integer $studentId
     */
    public function setStudentId($studentId)
    {
        $this->setStudentIdentifierAttribute($studentId);
//        $this->attributes['student_identifier'] = $studentId;
        //$this->attributes['student_identifier'] = Crypt::encrypt($studentId);
    }


    /**
     * Sets the student's first name
     * NB., does not save the change. So update needs to be independently called.
     * @param string $firstName
     */
    public function setStudentFName($firstName)
    {
        $this->setFirstNameAttribute($firstName);
//        $this->setAttribute('first_name', $firstName);
//        $this->attributes['first_name'] = $firstName;
    }

    /**
     * Returns the student's first name
     * @return string
     */
    public function getStudentFName()
    {
        return $this->getFirstNameAttribute();
//        return $this->getAttribute('first_name');
//       return $this->attributes['first_name'];
    }

    /**
     * Sets the student's last name
     * NB., does not save the change. So update needs to be independently called.
     * @param string $lastName
     */
    public function setStudentLName($lastName)
    {
        $this->setLastNameAttribute($lastName);
//        $this->setAttribute('last_name', $lastName);
//        $this->attributes['last_name'] = $lastName;
    }

    /**
     * Returns the student's last name
     * @return string
     */
    public function getStudentLName()
    {
        return $this->getLastNameAttribute();
//        return $this->getAttribute('last_name');
//        return $this->attributes['last_name'];
    }


    /**
     * Returns the student's email address.
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getEmailAttribute();
//        return $this->getAttribute('email');
//        return $this->attributes['email'];
//        if( ! empty($this->attributes['email']) )
//        {
//            return Crypt::decrypt($this->attributes['email']);
//        }
//        return null;
    }


    /**
     * Change email address for student.
     * NB., does not save the change. So update needs to be independently called.
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->setEmailAttribute($email);
//        $this->setAttribute('email', $email);
//        $this->attributes['email'] = $email;
//        $this->attributes['email'] = Crypt::encrypt($email);
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
        $query = <<<MYSQL
        SELECT count(qs.score) AS numberAnswered 
        FROM question_scores qs 
        INNER JOIN question_assignments qa ON qa.id = qs.question_assignment_id 
        WHERE qa.exam_id = :examId AND qs.student_id = :studentId;
        
MYSQL;
        $values = ['examId' => $examId, 'studentId' => $this->attributes['id']];
        $result = DB::select($query, $values);
        if ( $result[0]->numberAnswered > 0 )
        {
            return true;
        }

        return false;
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
        if ( ! is_null($expirationDate) )
        {
            if ( Carbon::now()->lte($expirationDate) )
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
        return $this->belongsToMany(Kumi::class, 'kumi_student')
            ->withTimestamps();
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

<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get all exams belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllExams()
    {
        return $this->hasMany('App\Exam');
    }

    /**
     * Get all elements belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllElements()
    {
        return $this->hasMany('App\Element');
    }

    /**
     * Get all element assignments belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllElementAssignments()
    {
        return $this->hasMany('App\ElementAssignment');
    }

    /**
     * Get all element scores belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllElementScores()
    {
        return $this->hasMany('App\ElementScore');
    }

    /**
     * Get all questions belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllQuestions()
    {
        return $this->hasMany('App\Question');
    }

    /**
     * Get all question assignments belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllQuestionAssignments()
    {
        return $this->hasMany('App\QuestionAssignment');
    }

    /**
     * Get all question scores belonging to user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllQuestionScores()
    {
        return $this->hasMany('App\QuestionScore');
    }

    /**
     * Gets all students belonging to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAllStudents()
    {
        return $this->hasMany('App\Student');

    }

    /**
     * Checks whether the logged in user is the same as the owner
     * of the model.
     *
     * @param $related A model with a user_id attribute
     * @return bool
     */
    public function owns($related)
    {
        return $this->id == $related->user_id;
    }


}

<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

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


}

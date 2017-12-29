<?php

namespace App;

use App\Models\Preferences\GradePreferences;
use App\Models\Preferences\SetupPreferences;
use App\Models\Preferences\UserPreferences;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;


/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword, Notifiable;


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
    public function owns( $related )
    {
        return $this->id == $related->user_id;
    }


    /* -------------------------- Notifications --------------------- */

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return env('SLACK_HOOK_NEW_USER', '');
    }

    /* ------------------------------ Preferences ---------------------- */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grade_preferences()
    {
        return $this->hasOne(GradePreferences::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setup_preferences()
    {
        return $this->hasOne(SetupPreferences::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_preferences()
    {
        return $this->hasOne(UserPreferences::class);
    }
}

<?php

namespace App;

/**
 * Class Kumi
 * Japanese for 'class' as in 'I want this exam to be associated with three classes'.
 * 
 * Because if you go around calling something 'class' in methods which take
 * strings as arguments, bad things can happen.
 *
 * @package App
 * @property integer $id
 * @property integer $user_id
 * @property integer $year
 * @property string $nickname
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exam[] $exams
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kumi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel loggedIn()
 * @mixin \Eloquent
 */
class Kumi extends BaseModel
{
    /** Maximum length in utf-8 characters of the name field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in digits of the year field (used in sanitizing) */
    const MAX_YEAR_LENGTH = 4;

    protected $casts = [
        'name' => 'string',
        'year' => 'integer',
        'is_roster' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'year',
        'is_roster' //Whether or not this is a base kumi which each exam has one of
    ];

    /**
     * Sets the name of the class (kumi)
     * @param string $name
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }

    /**
     * Sets the year of the class
     * @param integer $year
     */
    public function setYear($year)
    {
        $this->attributes['year'] = $year;
    }

#--------- Foreign keys
    /**
     * Students associated with the class/kumi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'kumi_student')
            ->withTimestamps();
    }

    /**
     * The user the class/kumi belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Exams associated with the class/kumi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_kumi')->withTimestamps();
    }


}

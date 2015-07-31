<?php

namespace App;

/**
 * Class Kumi
 * Japanese for 'class' as in 'I want this exam to be associated with three classes'.
 * Because if you go around calling something 'class' in methods which take
 * strings as arguments, bad things can happen.
 *
 * @package App
 */
class Kumi extends BaseModel
{
    /** Maximum length in utf-8 characters of the name field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in digits of the year field (used in sanitizing) */
    const MAX_YEAR_LENGTH = 4;

    protected $casts = [
        'nickname' => 'string',
        'year' => 'integer'
    ];

    protected $fillable = [
        'nickname',
        'year'
    ];

    public function __construct()
    {
        parent::boot();
    }

    /**
     * Sets the name of the class (kumi)
     * @param string $name
     */
    public function setName($name)
    {
        $this->attributes['nickname'] = $name;
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
        return $this->belongsToMany('App\Student', 'kumi_student')->withTimestamps();
    }

    /**
     * The user the class/kumi belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Exams associated with the class/kumi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams()
    {
        return $this->belongsToMany('App\Exam', 'exam_kumi')->withTimestamps();
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;


/**
 * App\GradingTime
 *
 * @property integer $id
 * @property integer $exam_id
 * @property integer $student_id
 * @property float $seconds
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Student $student
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereExamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereSeconds($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradingTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GradingTime extends Model
{
    protected $fillable = [];

    protected $casts = [
        'seconds' => 'float',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

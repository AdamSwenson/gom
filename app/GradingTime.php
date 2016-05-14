<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;


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

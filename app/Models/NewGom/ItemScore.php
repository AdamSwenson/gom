<?php

namespace App\Models\NewGom;

use App\BaseModel;
use App\Exam;
use App\Item;
use App\Student;
use App\User;

class ItemScore extends BaseModel
{
    protected $fillable = ['score', 'commentText'];

    protected $casts = [
        'score' => 'float'
    ];


#---- foreign keys
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

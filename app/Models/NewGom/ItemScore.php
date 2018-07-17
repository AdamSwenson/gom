<?php

namespace App\Models\NewGom;

use App\BaseModel;
use App\Exam;
use App\Item;
use App\Kumi;
use App\Student;
use App\User;

class ItemScore extends BaseModel
{
    protected $fillable = ['score', 'commentText'];

    protected $casts = [
        'score' => 'float'
    ];

    /**
     * Returns false if the score is not to influence the overall grade,
     * todo This will be fleshed out in GOM-347
     * @returns {boolean}
     */
    public function countsTowardTotalScore()
    {
        return true;
    }


#---- foreign keys
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
//     */
//    public function kumis(){
//        return $this->hasManyThrough(Kumi::class, Student::class, 'id', 'kumi_id', 'student_id');
//    }

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

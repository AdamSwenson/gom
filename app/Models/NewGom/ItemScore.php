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
    protected $fillable = ['score', 'comment_text'];

    protected $casts = [
        'score' => 'float'
    ];

    /**
     * Returns false if the score is not to influence the overall grade.
     * This will be true if the item is either ungraded or extra credit
     * 
     * Added in GOM-347
     * @returns {boolean}
     */
    public function countsTowardTotalScore()
    {
        $r = $this->item->countsTowardTotalScore();

        //for compatibility with earlier data
        if(is_null($r)) return true;

        return $r;
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

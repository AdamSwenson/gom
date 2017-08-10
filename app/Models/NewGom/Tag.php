<?php

namespace App\Models\NewGom;

use App\BaseModel;
use App\Exam;
use App\Item;
use App\Student;
use App\User;

class Tag extends BaseModel
{

    protected $fillable = ['name', 'text', 'props'];

    protected $casts = [
        'props' => 'array'
    ];


#---- foreign keys
    public function exams()
    {
        //using many in case want to have options for
        //applying a note to ranges of items / exams
        //maybe like "don't use"
        return $this->belongsToMany(Exam::class, 'exam_tag')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_tag')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function student(){
        return $this->belongsToMany(Student::class, 'student_tag')
            ->withTimestamps();
    }

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

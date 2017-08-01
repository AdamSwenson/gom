<?php

namespace App\Models\NewGom;

use App\BaseModel;
use App\Exam;
use App\Item;
use App\Student;
use App\User;


/**
 * Class Note
 * These are associated with items or exams
 * There can be several associated with one exam
 * @package App\Models\NewGom
 */
class Note extends BaseModel
{
    const PRIORITY_LEVELS = [ 0, 1, 2, 3];

    protected $fillable = ['name', 'text', 'priority', 'props'];

    protected $casts = [
        'props' => 'array'
    ];


#---- foreign keys
    public function exam()
    {
        //using many in case want to have options for
        //applying a note to ranges of items / exams
        //maybe like "don't use"
        return $this->belongsToMany(Exam::class, 'exam_note')
            ->withTimestamps();
    }

    public function item()
    {
        return $this->belongsToMany(Item::class, 'item_note')
            ->withTimestamps();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
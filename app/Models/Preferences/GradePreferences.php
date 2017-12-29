<?php

namespace App\Models\Preferences;

use App\BaseModel;
use App\User;

class GradePreferences extends BaseModel
{
    protected $fillable = ['preferences'];

    protected $casts = [
        'preferences' => 'array'
    ];

    static public $defaultPreferences = [
        'areStudentNamesVisible' => true,
        'isLetterGradeButtonUsed' => true,
        'shouldDynamicallyCollapseCommentAreas' => true,
        'isSliderUsed' => true,
        'isScoreDisplayed' => true
    ];

    public function setPreference($property, $newValue){
//        $this->preferences[$property] = $newValue;
        $a = $this->preferences;
//        //$a = $this->attributes['preferences']->toArray();
//
        $a[$property] = $newValue;
//        var_dump($a);
//
        $this->preferences = $a;
//        $this->attributes['preferences'] = $a;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

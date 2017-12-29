<?php

namespace App\Models\Preferences;

use App\BaseModel;
use App\User;

class UserPreferences extends BaseModel
{

    protected $fillable = ['preferences'];

    protected $casts = [
        'preferences' => 'array'
    ];

    static public $defaultPreferences = [
        'userNameShownToStudents' => '',
        'userEmailSignature' => ''

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

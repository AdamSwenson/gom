<?php

namespace App\Models\Preferences;

use App\BaseModel;
use App\User;

class UserPreferences extends PreferenceBase
{

    protected $fillable = ['preferences'];

    protected $casts = [
        'preferences' => 'array'
    ];

    static public $defaultPreferences = [
        'userNameShownToStudents' => '',
        'userEmailSignature' => ''

    ];

}

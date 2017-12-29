<?php

namespace App\Models\Preferences;

use App\BaseModel;
use App\User;

class SetupPreferences extends BaseModel
{
    protected $fillable = ['preferences'];

    protected $casts = [
        'preferences' => 'array'
    ];

    static public $defaultPreferences = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

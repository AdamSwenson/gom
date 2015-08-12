<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingTime extends Model
{
    protected $fillable = [];

    protected $casts = [
        'seconds' => 'float'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $user = Auth::user();
            if ( ! $user->isValid()) return false;
            $model->user_id = $user->id;
            $model->user_id = $user->id;
        });

        static::updating(function($model)
        {
            $user = Auth::user();
            if ( ! $user->isValid()) return false;
            $model->user_id = $user->id;
        });
    }



}

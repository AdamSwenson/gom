<?php

namespace App;

use App\UserOnlyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserOnlyScope());

        static::creating(function($model)
        {
            $user = \Auth::user();
            $model->user_id = $user->id;
        });

        static::updating(function($model)
        {
            $user = \Auth::user();
            $model->user_id = $user->id;
        });

        static::deleting(function($model){
            $user = \Auth::user();
            $model->user_id = $user->id;
        });

    }

    public static function junctionBoot()
    {
        static::addGlobalScope(new \App\UserOnlyJunctionScope());

        static::creating(function($model)
        {
            $user = \Auth::user();
            $model->owner_id = $user->id;
        });

        static::updating(function($model)
        {
            $user = \Auth::user();
            $model->owner_id = $user->id;
        });

        static::deleting(function($model){
            $user = \Auth::user();
            $model->owner_id = $user->id;
        });
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

//    /**
//     * Get random models
//     * @param $query
//     * @return
//     */
//    public function scopeRandomObject($query, $table)
//    {
//        return $query->orderByRaw('RAND()');
//    }


}

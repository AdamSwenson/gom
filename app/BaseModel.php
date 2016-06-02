<?php

namespace App;

use App\Exceptions\NotLoggedInException;
use App\Scopes\UserOnlyJunctionScope;
use App\Scopes\UserOnlyScope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{

    /**
     * Retrieves the logged in user. If user is not logged in, will throw
     * an exception which redirects to the log in page.
     * @return User
     * @throws NotLoggedInException
     */
    static protected function getLoggedInUser()
    {
        $user = \Auth::user();
        if ( ! $user )
        {
            throw new NotLoggedInException;
        }

        return $user;
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserOnlyScope);

        static::creating(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->user_id = $user->id;
        });

        static::updating(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->user_id = $user->id;
        });

        static::deleting(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->user_id = $user->id;
        });


    }

    public static function junctionBoot()
    {
        static::addGlobalScope(new UserOnlyJunctionScope());

        static::creating(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->owner_id = $user->id;
        });

        static::updating(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->owner_id = $user->id;
        });

        static::deleting(function ($model)
        {
            $user = self::getLoggedInUser();
            $model->owner_id = $user->id;
        });
    }

    public function scopeLoggedIn($query)
    {
        return $query->where('user_id', \Auth::user()->id);
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

    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }


}

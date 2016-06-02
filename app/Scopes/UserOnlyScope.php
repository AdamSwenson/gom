<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/16
 * Time: 10:30 AM
 */

namespace App\Scopes;

use App\Exceptions\NotLoggedInException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserOnlyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return $this|void
     * @throws NotLoggedInException
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ( ! $user )
        {
            throw new NotLoggedInException;
        }

        return $builder->where('user_id', $user->id);
    }

}
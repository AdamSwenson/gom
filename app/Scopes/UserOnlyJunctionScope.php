<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 6:08 PM
 */


namespace App\Scopes;

use App\Exceptions\NotLoggedInException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;



/**
 * Class UserOnlyJunctionScope
 *
 * Does same thing as useronly scope but for junction tables
 *
 * @package App
 */
class UserOnlyJunctionScope implements Scope
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
        if(! $user ){ throw new NotLoggedInException;}

        return $builder->where('owner_id', $user->id);
    }

}
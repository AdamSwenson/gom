<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 9:13 AM
 */
namespace App;
use Exceptions\NotLoggedInException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

/**
 * Class UserOnlyScope
 * Limits queries to things associated with the user
 */
class UserOnlyScope implements ScopeInterface
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     * @throws NotLoggedInException
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = \Auth::user();
        if(! $user ){ throw new NotLoggedInException;}
        $builder->where('user_id', $user->id);
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     *
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        // TODO: Implement remove() method.
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 6:08 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;


/**
 * Class UserOnlyJunctionScope
 *
 * Does same thing as useronly scope but for junction tables
 *
 * @package App
 */
class UserOnlyJunctionScope implements ScopeInterface
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = \Auth::user();
        $builder->where('owner_id', $user->id);
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
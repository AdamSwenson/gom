<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/10/16
 * Time: 8:20 PM
 */


namespace App;

use App\UserOnlyJunctionScope;
use App\UserOnlyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * The standard base model automatically adds the user id to the
 * model and restricts searches to the logged in user.
 * 
 * However, sometimes there's a need for a model which is
 * not always tied to a user (for example, AccessKey). Such
 * models should inherit from this
 *
 * @package App
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModelNoUser loggedIn()
 * @mixin \Eloquent
 */
class BaseModelNoUser extends Model
{
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
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

}
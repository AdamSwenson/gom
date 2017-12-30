<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 12/29/17
 * Time: 12:35 PM
 */

namespace App\Models\Preferences;


use App\BaseModel;

class PreferenceBase extends BaseModel
{

    public function setPreference($property, $newValue){
//        $this->preferences[$property] = $newValue;
        $a = $this->preferences;
//        //$a = $this->attributes['preferences']->toArray();
//
        $a[$property] = $newValue;
//        var_dump($a);
//
        $this->preferences = $a;
//        $this->attributes['preferences'] = $a;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
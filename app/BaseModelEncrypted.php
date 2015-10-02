<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/1/15
 * Time: 4:06 PM
 */

namespace App;

use Illuminate\Support\Facades\Crypt;

/**
 * This is the usual base for eloquent models with the addition
 * of an array $encryptedAttributes which are encrypted and decrypted
 * upon access.
 * @package App
 */
class BaseModelEncrypted extends BaseModel
{

    protected $encryptedAttributes = [];

    public function __construct()
    {
        parent::boot();
    }


    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptedAttributes))
        {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->encryptedAttributes) && !empty($this->attributes[$key]) )
        {
            return Crypt::decrypt($this->attributes[$key]);
        }

        return parent::getAttribute($key);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($attributes as $key => $value)
        {
            if (in_array($key, $this->encryptedAttributes) && !empty($attributes[$key]))
            {
                $attributes[$key] = Crypt::decrypt($value);
            }
        }

        return $attributes;
    }

}
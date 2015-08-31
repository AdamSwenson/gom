<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['access_key', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    protected $table = 'feedback';

    protected $primaryKey = 'access_key';


    public function setAccessKey($accessKey)
    {
        $this->attributes['access_key'] = $accessKey;
    }

//    public function setContent($content)
//    {
//        $this->attributes['content'] = $content;
//    }

    public function scopeByAccessKey($query, $accessKey)
    {
        return $query->where('access_key', $accessKey);
    }
}

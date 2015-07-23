<?php

namespace App;


class Comment extends BaseModel
{
    const VALENCE_ABSENT = 'absent';
    const VALENCE_POOR = 'poor';
    const VALENCE_OK = 'ok';
    const VALENCE_EXCELLENT = 'excellent';

    const MAX_BODY_LENGTH = 3000;

    public static $valences = [
        self::VALENCE_ABSENT,
        self::VALENCE_POOR,
        self::VALENCE_OK,
        self::VALENCE_EXCELLENT
    ];

    protected $fillable = [];

    protected $casts = [
        'valence' => 'string',
        'body' => 'string'
    ];

    public function __construct()
    {
        parent::boot();
    }

    /**
     * Sets the body text of the comment
     * @param $text
     */
    public function setBody($text)
    {
        $this->attributes['body'] = $text;
    }

    /**
     * Gets the body text of the comment
     * @return mixed
     */
    public function getBody()
    {
        return $this->attributes['body'];
    }

    /**
     * Sets the valence of the comment. Must be a value stored in one of this
     * class's constants.
     *
     * @param $valence
     * @throws \Exception
     */
    public function setValence($valence)
    {
        switch($valence)
        {
            case self::VALENCE_ABSENT:
                $this->attributes['valence'] = self::VALENCE_ABSENT;
                break;
            case self::VALENCE_POOR:
                $this->attributes['valence'] = self::VALENCE_POOR;
                break;
            case self::VALENCE_OK:
                $this->attributes['valence'] = self::VALENCE_OK;
                break;
            case self::VALENCE_EXCELLENT:
                $this->attributes['valence'] = self::VALENCE_EXCELLENT;
                break;
            default:
                throw new \Exception('invalid valence');
        }
    }

    /**
     * Gets the valence of the comment.
     * Will be a value from this class's constants.
     */
    public function getValence()
    {
        $this->attributes['valence'];
    }

#----------------- foreign keys
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function element()
    {
        return $this->belongsToMany('App\Element', 'comment_element')->withTimestamps();
    }
}

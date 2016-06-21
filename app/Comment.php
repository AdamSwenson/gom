<?php

namespace App;

/**
 * Class Comment
 * 
 * These are the atoms of feedback given to the user. They are created
 * from the base text in the element. But once they exist, they are edited on their own.
 * 
 * Note: I'm not sure why I thought I needed a junction table to do this,
 * but I did. Thus this is treated as a many-many relationship. If that isn't
 * necessary, this can be refactored to just have the element_id as a field in
 * the comments table.
 *
 * @package App
 * @property integer $id
 * @property integer $user_id
 * @property integer $element_id
 * @property string $valence
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Element $element
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereElementId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereValence($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment onValence($valence)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel loggedIn()
 * @mixin \Eloquent
 */
class Comment extends BaseModel
{
    const VALENCE_ABSENT = '0';
    const VALENCE_POOR = '1';
    const VALENCE_OK = '2';
    const VALENCE_EXCELLENT = '3';

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
        return $this->attributes['valence'];
    }

    #---------------------------------------- queries
    /**
     * Limits query to comments with the specified valence
     * @param $query
     * @param $valence
     * @return mixed
     */
    public function scopeOnValence($query, $valence)
    {
        return $query->where('valence', $valence);
    }
//
//    public function scopeOnElement($query, $elementId)
//    {
//        return $query->element->where('element_id', $elementId);
//    }


#----------------- foreign keys
    /**
     * Junction with user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Association with element.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function element()
    {
        return $this->belongsTo('App\Element');
//        return $this->belongsToMany('App\Element', 'comment_element')->withTimestamps();
    }
}

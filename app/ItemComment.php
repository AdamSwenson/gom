<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ItemComment
 * New version of gom
 * Comment attached to an item
 *
 * @todo This has the standardized valence values (the db is varchar). Eventually should be arbitrarily settable
 *
 * @package App
 */
class ItemComment extends BaseModel
{

    use SoftDeletes;

    const VALENCE_ABSENT = 0;
    const VALENCE_BOTTOM = 1;
    const VALENCE_MIDDLE = 2;
    const VALENCE_TOP = 3;
    const VALENCE_STOCK = 4;

    const TEXT_ABSENT = 'absent';
    const TEXT_BOTTOM = 'poor';
    const TEXT_MIDDLE = 'good';
    const TEXT_TOP = 'excellent';
    const TEXT_STOCK = 'stock';

    const MAX_BODY_LENGTH = 3000;

    public static $valences = [
        self::VALENCE_ABSENT,
        self::VALENCE_BOTTOM,
        self::VALENCE_MIDDLE,
        self::VALENCE_TOP
    ];

    public static $valenceTexts = [
        'stock', 'absent', 'poor', 'good', 'excellent'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $guarded = ['user_id', 'id'];


    protected $fillable = ['item_id', 'valence', 'body'];

    protected $casts = [
        'body' => 'string'
    ];


    /**
     * Sets the body text of the comment
     * @param $text
     */
    public function setBody( $text )
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

    public static function numericValenceFromText( $valence )
    {
        switch ( $valence ) {
            case self::TEXT_ABSENT:
                return self::VALENCE_ABSENT;
                break;
            case self::TEXT_BOTTOM:
                return self::VALENCE_BOTTOM;
                break;
            case self::TEXT_MIDDLE:
                return self::VALENCE_MIDDLE;
                break;
            case self::TEXT_TOP:
                return self::VALENCE_TOP;
                break;
            case self::TEXT_STOCK:
                return self::VALENCE_STOCK;
            default:
                throw new \Exception('invalid valence');
        }
    }


    public static function textValenceFromNumber( $valence )
    {
        switch ( $valence ) {
            case self::VALENCE_ABSENT:
                return self::TEXT_ABSENT;
                break;
            case self::VALENCE_BOTTOM:
                return self::TEXT_BOTTOM;
                break;
            case self::VALENCE_MIDDLE:
                return self::TEXT_MIDDLE;
                break;
            case self::VALENCE_TOP:
                return self::TEXT_TOP;
                break;
            case self::VALENCE_STOCK:
                return self::TEXT_STOCK;
                break;
            default:
                throw new \Exception('invalid valence');
        }
    }

//    /**
//     * Setter
//     * Sets the valence of the comment. Must be a value stored in one of this
//     * class's constants.
//     *
//     * @param $valence
//     * @throws \Exception
//     */
//    public function setValence( $valence )
//    {
//   The below switch seems pointless
        //If we end up using this mutator, a statement like the following
    //will be easier
//        if(array_has(self::$valences, $valence)
//        {
//        $this->attributes['valence'] = $valence;
//
//    }
//        switch ( $valence ) {
//            case self::VALENCE_ABSENT:
//                $this->attributes['valence'] = self::VALENCE_ABSENT;
//                break;
//            case self::VALENCE_BOTTOM:
//                $this->attributes['valence'] = self::VALENCE_BOTTOM;
//                break;
//            case self::VALENCE_MIDDLE:
//                $this->attributes['valence'] = self::VALENCE_MIDDLE;
//                break;
//            case self::VALENCE_TOP:
//                $this->attributes['valence'] = self::VALENCE_TOP;
//                break;
//            default:
//                throw new \Exception('invalid valence');
//        }
//    }

    /**
     * Returns the string version of this
     * comment's valence
     */
    public function getTextValence()
    {
        return self::textValenceFromNumber($this->attributes['valence']);
    }

    /**
     * Getter
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
    public function scopeOnValence( $query, $valence )
    {
        return $query->where('valence', $valence);
    }


#----------------- foreign keys

    /**
     * Junction with user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Association with item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

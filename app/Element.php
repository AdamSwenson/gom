<?php

namespace App;

class Element extends BaseModel
{
    /** Maximum length in utf-8 characters of the elementName field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in utf-8 characters of the displayText field (used in sanitizing) */
    const MAX_DISPLAY_LENGTH = 200;

    /** Maximum length in utf-8 characters of the commentText field (used in sanitizing) */
    const MAX_COMMENT_LENGTH = 3000;

    protected $fillable = [
        'elementName',
        'displayText',
        'commentText'
    ];

    protected $casts = [
        'elementName' => 'string',
        'displayText' => 'string',
        'commentText' => 'string'
    ];

# -------------- getters and setters

    /**
     * Sets the name of the element
     * @param string $elementName
     */
    public function setElementName($elementName)
    {
        $this->attributes['elementName'] = $elementName;
    }

    /**
     * Sets the text to be displayed while grading
     * @param string $displayText
     */
    public function setDisplayText($displayText)
    {
        $this->attributes['displayText'] = $displayText;
    }

    /**
     * Sets the base comment text
     * @param string $commentText
     */
    public function setCommentText($commentText)
    {
        $this->attributes['commentText'] = $commentText;
    }

    /**
     * Gets the name of the element
     * @return string
     */
    public function getElementName()
    {
        return $this->attributes['elementName'];
    }

    /**
     * Gets the text to be displayed while grading
     * @return string
     */
    public function getDisplayText()
    {
        return $this->attributes['displayText'];
    }

    /**
     * Gets the base comment text
     * @return string
     */
    public function getCommentText()
    {
        return $this->attributes['commentText'];
    }
//
//    /**
//     * Handle legacy and aliased method calls.
//     *
//     * @param  string $method
//     * @param  array $parameters
//     * @return mixed
//     */
//    public function __call($method, $parameters)
//    {
//        switch($method)
//        {
//            case 'getDisplaytext':
//                $this->getDisplayText();
//                break;
//            case 'getElementname':
//                $this->getElementName();
//                break;
//            case 'getCommenttext':
//                $this->getCommentText();
//                break;
//            case 'setDisplaytext':
//                $this->setDisplayText($parameters);
//                break;
//            case 'setElementname':
//                $this->getElementName($parameters);
//                break;
//            case 'setCommenttext':
//                $this->setCommentText($parameters);
//                break;
//            default:
//                break;
//        }
//    }


#----------------- foreign keys
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'element_assignments');
    }

    public function scores()
    {
        return $this->hasManyThrough('App\ElementScore', 'App\ElementAssignment');
    }
}

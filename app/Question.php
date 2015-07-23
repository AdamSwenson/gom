<?php

namespace App;


class Question extends BaseModel
{
    /** Maximum length in utf-8 characters of the name field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;

    /** Maximum length in utf-8 characters of the text field (used in sanitizing)  */
    const MAX_TEXT_LENGTH = 2000;

    /** @var array Fields that are mass assignable */
    protected $fillable = [
        'questionText',
        'questionName'
    ];

    protected $casts = [
        'questionText' => 'string',
        'questionName' => 'string'
    ];

    public function __construct()
    {
        parent::boot();
    }

    /**
     * Sets the text of the question
     * @param string $questionText
     */
    public function setQuestionText($questionText)
    {
        $this->attributes['questionText'] = $questionText;
    }

    /**
     * Sets the name of the question
     * @param string $questionName
     */
    public function setQuestionName($questionName)
    {
        $this->attributes['questionName'] = $questionName;
    }

    /**
     * Returns the id of the question
     * @return integer
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Getter for the text field
     * @return string
     */
    public function getQuestionText()
    {
        return $this->attributes['questionText'];
    }

    /**
     * Getter for the question name field
     * @return string
     */
    public function getQuestionName()
    {
        return $this->attributes['questionName'];
    }

//    /**
//     * Handles legacy and alias method names.
//     *
//     * @param  string $method
//     * @param  array $parameters
//     * @return mixed
//     * @throws \Exception
//     */
//    public function __call($method, $parameters)
//    {
//        try
//        {
//            parent::$method($parameters);
//        } catch (\Exception $e)
//        {
//            switch ($method)
//            {
//                case 'getText':
//                    $this->getQuestionText();
//                    break;
//                case 'getName':
//                    $this->getQuestionName();
//                    break;
//                case 'getQuestiontext':
//                    $this->getQuestionText();
//                    break;
//                case 'getQuestionname':
//                    $this->getQuestionName();
//                    break;
//                case 'setQuestiontext':
//                    $this->setQuestionText($parameters);
//                    break;
//                case 'setQuestionname':
//                    $this->setQuestionName($parameters);
//                    break;
//                default:
//                    throw new \Exception('bad method request');
//            }
//        }
//    }


    #------------ foreign keys
    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function questionAssignments()
    {
        return $this->hasMany('App\QuestionAssignment');
    }

    public function scores()
    {
        return $this->hasMany('App\QuestionScore');
    }

}

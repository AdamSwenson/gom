<?php

namespace App;


use Illuminate\Support\Facades\DB;

class Question extends BaseModel
{
    /** Maximum length in utf-8 characters of the name field (used in sanitizing) */
    const MAX_NAME_LENGTH = 200;
    /** Minimum length in utf-8 characters of the name field (used in sanitizing) */
    const MIN_NAME_LENGTH = 2;

    /** Maximum length in utf-8 characters of the text field (used in sanitizing)  */
    const MAX_TEXT_LENGTH = 2000;
    /** Minimum length in utf-8 characters of the text field (used in sanitizing)  */
    const MIN_TEXT_LENGTH = 2;

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

    /**
     * Gets the question number of the present question on the specified exam
     * @param integer $examId
     * @return integer|null
     */
    public function getQuestionNumber($examId)
    {
        $exam = $this->exam()->where('exam_id', $examId)->first();

        return $exam->pivot->question_number;
    }

    /**
     * Assigns this question to an exam as the specified question number
     * @param integer $examId
     * @param integer $questionNumber
     * @return Question
     */
    public function setQuestionNumber($examId, $questionNumber)
    {
        $query = 'CALL assign_question(:questionId, :examId, :questionNumber)';
        $values = [
            'questionId' => $this->attributes['id'],
            'examId' => $examId,
            'questionNumber' => $questionNumber
        ];

        DB::statement($query, $values);

//        $pre_existing = QuestionAssignment::where('exam_id', $examId)->where('question_number', $questionNumber);
//        if ($pre_existing)
//        {
//            $pre_existing->delete();
//        }
//        $pre_assigned = QuestionAssignment::where('exam_id', $examId)->where('question_id', $this->getId());
//        if ($pre_assigned)
//        {
//            $pre_assigned->delete();
//        }
//        $this->exam()->attach($examId, ['question_number' => $questionNumber]);

        return $this;
    }


    #------------ foreign keys
    /**
     * Returns associated exams. Returns exam object collection
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exam()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     * Returns associated user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns associated exams. Returns exam object collection
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questionAssignments()
    {
        return $this->belongsToMany('App\Exam', 'question_assignments')->withPivot('question_number')->withTimestamps();
    }

    /**
     * Returns associated scores
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function scores()
    {
        return $this->hasManyThrough('App\QuestionScore', 'App\QuestionAssignment', 'question_id',
            'question_assignment_id');
    }

    //    public function elements()
//    {
//        $this->hasManyThrough('App\Element', 'App\Q')
//    }


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


}

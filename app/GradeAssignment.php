<?php

namespace App;

use App\Repositories\Grade\GradeFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is a representation of the criterion for assigning a single
 * grade on an exam based on total score
 * 
 * It has the attributes:
 *  exam_id: integer
 *  user_id: integer
 *  min_score: float The cut off for applying the grade
 *  grade: App\Grade Model representing the grade
 *  grade_id: integer Id of grade (this value is stored in the db
 *
 * @package App
 * @property integer $id
 * @property integer $user_id
 * @property integer $exam_id
 * @property integer $grade_id
 * @property float $min_score
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $grade
 * @property-read \App\Exam $exam
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereExamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereMinScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GradeAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel loggedIn()
 * @mixin \Eloquent
 */
class GradeAssignment extends BaseModel
{

    protected $grade;

    /** @var array Fields that are mass assignable */
    protected $fillable = [
    'min_score'
        ];

    protected $casts = [
        'min_score' => 'float'
    ];


    /**
     * Creates a grade assignment for each of the standard grades on the
     * exam. The minimum scores will be null unless $setDefaultCutoffs is true
     *
     * @param Exam $exam
     * @param bool $setDefaultCutoffs
     */
    static public function initializeOnExam(Exam $exam, $setDefaultCutoffs=false){
        foreach( GradeFactory::$grades as $standardGrade){
            $grade = Grade::where('display_value', $standardGrade['display_value'])->first();

            //todo this could be problematic later. we probably will need to flag the defaults or store them
            $assignment = new GradeAssignment();
            $assignment->exam()->associate($exam);
            $assignment->grade()->associate($grade);

            if($setDefaultCutoffs){
                $assignment->min_score = $grade->default_cutoff * $exam->getMaxPossibleScore();
            }

            $assignment->save();
        }

    }

    /* -------------------------------- Relationships ---------------------------------- */
    /**
     * Junction to the grade object
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grade()
    {
       return $this->belongsTo(Grade::class);
    }

    /**
     * Junction to the exam object
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * The user the grade assignment belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Sets the lower bound for the grade assignment.
     * Any student with a score greater than this value (where there is no other
     * gradeAssignment with a higher value) will receive the associated grade.
     *
     * @param float $minScore
     */
    public function setMinScore($minScore)
    {
        $this->attributes['min_score'] = $minScore;
    }

    /**
     * Retrieves the lower bound for the grade assignment
     *
     * @return float
     */
    public function getMinScore()
    {
        return $this->attributes['min_score'];
    }


    /**
     * Sets the grade property with the grade object and sets the grade_id attribute
     * with the grade object's id.
     *
     * Note that this is not done via an eloquent relationship because don't want to accidentally
     * delete the grade from the database.
     * @param Grade $grade
     */
    public function setGrade(Grade $grade)
    {
        $this->grade = $grade;
        $this->attributes['grade_id'] = $this->grade->getId();
    }

    /**
     * Returns the grade object
     * @return Grade
     */
    public function getGrade()
    {
        return $this->getGradeAttribute();

//        //If grade model object not yet set, set it
//        if( empty($this->grade) )
//        {
//            //If no grade id is set, we can't create a grade object. So just
//            //return null
//            if( empty($this->attributes['grade_id']))
//            {
//                return null;
//            }
//
//            $this->grade = GradeFactory::loadByGradeId($this->attributes['grade_id']);
//        }
//
//        return $this->grade;
    }

    /**
     * Laravel convention-using getter for grade
     */
    public function getGradeAttribute()
    {
        //If grade model object not yet set, set it
        if( empty($this->grade) )
        {
            //If no grade id is set, we can't create a grade object. So just
            //return null
            if( empty($this->attributes['grade_id']))
            {
                return null;
            }

            $this->grade = GradeFactory::loadByGradeId($this->attributes['grade_id']);
        }

        return $this->grade;
    }


    }

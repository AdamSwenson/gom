<?php

namespace App;


use Illuminate\Support\Facades\DB;

class ElementScore extends BaseModelNoUser
{
    protected $fillable = ['score', 'commentText'];

//    public function __construct()
//    {
////        parent::junctionBoot();
//    }


    /**
     * Records or updates the score for a student on a particular question.
     * Returns itself to allow for easy chaining with recordCommentText
     *
     * @param float $score
     * @return ElementScore
     */
    public function recordScore($score)
    {
        $query = "CALL record_element_score(:elementAssignmentId, :studentId, :score)";
        $values = [
            'elementAssignmentId' => $this->attributes['element_assignment_id'],
            'studentId' => $this->attributes['student_id'],
            'score' => $score
        ];
        if(DB::statement($query, $values))
        {
            $result = ElementScore::where('element_assignment_id', $this->attributes['element_assignment_id'])
                ->where('student_id', $this->attributes['student_id'])
                ->firstOrFail();
//            $result = DB::select('SELECT * FROM element_scores WHERE element_assignment_id = :elementAssignmentId AND student_id = :studentId',
//                       ['elementAssignmentId' => $this->attributes['element_assignment_id'],
//                       'studentId' => $this->attributes['student_id']]);
            if($result)
            {
                $this->attributes['id'] = $result->id;
                $this->attributes['score'] = $result->score;
                $this->attributes['comment_text'] = $result->comment_text;
            }
        }
        return $this;
    }

    /**
     * Adds or updates the comment text that the student will be given
     * for the element.
     *
     * @param string $text
     * @return ElementScore
     */
    public function recordCommentText($text)
    {
        $query = "CALL record_element_comment_text(:elementAssignmentId, :studentId, :commentText)";
        $values = [
            'elementAssignmentId' => $this->attributes['element_assignment_id'],
            'studentId' => $this->attributes['student_id'],
            'commentText' => $text
        ];
        if(DB::statement($query, $values))
        {
            $result = ElementScore::where('element_assignment_id', $this->attributes['element_assignment_id'])
                ->where('student_id', $this->attributes['student_id'])
                ->firstOrFail();
            if($result)
            {
                $this->attributes['id'] = $result->id;
                $this->attributes['score'] = $result->score;
                $this->attributes['comment_text'] = $result->comment_text;
            }
        }
        return $this;
    }


    /**
     * Returns results limited to the particular student
     * @param $query
     * @param $studentId
     * @return mixed
     */
    public function scopeOnStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Returns results limited to the question assignment id
     * @param $query
     * @param $elementAssignmentId
     * @return mixed
     */
    public function scopeOnElementAssignment($query, $elementAssignmentId)
    {
        return $query->whereElementAssignmentId($elementAssignmentId);
    }

    public function scopeOnStudentElementAssignment($query, $studentId, $elementAssignmentId)
    {
        return $query->where('student_id', $studentId)->where('element_assignment_id', $elementAssignmentId);
    }


    # -------------------------------- getters and setters
    /**
     * Associates with user
     * @param $user_id
     */
    public function setUser($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function setScore($score)
    {
        $this->attributes['score'] = $score;
    }

    /**
     * Returns the score for the element
     * @return mixed
     */
    public function getScore()
    {
        return $this->attributes['score'];
    }

#---- foreign keys

    public function user()
    {
        return $this->belongsTo('App\User');
    }

//    public function exam()
//    {
//        return $this->belongsTo('App\Exam', 'element_assignment_id');
//    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'element_scores', 'student_id', 'element_assignment_id')->withPivot('score')->withTimestamps();
    }

    public function elementAssignment()
    {
        return $this->belongsTo('App\ElementAssignment');
    }

    public function element()
    {
        return $this->belongsToMany('App\Element', 'element_assignments', 'id');
    }

//    public function question()
//    {
//        return $this->belongsTo('App\Question', 'element_assignment_id');
//    }



}

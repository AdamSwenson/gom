<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * This represents a single grade, i.e., the precious for students.
 *
 * The grades are shared across all users.
 * UPDATE: Nope not any more. Each user may modify the display value, the calc value, or the default weight
 *
 * Each grade has the following attributes:
 *  id: integer (auto incremented)
 *
 *  display_value: string
 *      This is the value that should be displayed to the student. It can be a numeric string.
 *
 *  calc_value: integer
 *      This is the value that statistical calculations on scores should use
 *
 *  default_cutoff: float
 *      The number to be multiplied against the maximum possible score on the exam in order
 *      to generate the initial cutoff values.
 *
 * group: integer
 *      If we allow users to define groups of grades for customizable grading schemes,
 *      this value identifies the group
 *
 *  ordinal: integer
 *      The position in the overall order of the grade.
 *      Once we allow customization, we can't just use calc_value since
 *      not every grade may have such a value, or multiple grades might
 *      have the same value.
 *
 *
 * @package App
 */
class Grade extends BaseModel
{

    protected $guarded = ['user_id', 'id'];

    protected $casts = [
        'display_value' => 'string',
        'calc_value' => 'float',
        'default_cutoff' => 'float',
        'ordinal' => 'integer',
        'group' => 'integer'
    ];

//
//
//    protected $displayValue;
//    protected $calcValue;
//    protected $gradeId;
//
//    public function __construct($gradeId, $displayValue, $calcValue)
//    {
//        $this->attributes['id'] = $gradeId;
//        $this->gradeId = $gradeId;
//
//        $this->attributes['display_value'] = $displayValue;
//        $this->displayValue = $displayValue;
//
//        $this->attributes['calc_value'] = $calcValue;
//        $this->calcValue = $calcValue;
//    }


    /**
     * Returns the string to be displayed to students
     * @return string
     */
    public function getDisplayValue()
    {
        return $this->attributes['display_value'];
    }

    /**
     * Returns the value to be used in statistical calculations
     *
     * @return integer|mixed
     */
    public function getCalcValue()
    {
        return $this->attributes['calc_value'];
    }

    public function getId()
    {
        return $this->attributes['id'];
    }
}

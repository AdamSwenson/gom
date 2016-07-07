<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * This represents a single grade, i.e., the precious for students.
 *
 * The grades are shared across all users.
 *
 * Each grade has the following attributes:
 *  id: integer
 *      Uniquely identifies the grade. Also gives the ordinal location of the grade (i.e., which
 *      other grades it is higher than and which grades it is lower than).
 *      This is not an auto-incremented value. It is fixed in the database (by being defined in the migration)
 *      and should not be altered.
 *
 *  displayValue: string
 *      This is the value that should be displayed to the student. It can be a numeric string.
 *
 *  calcValue: integer
 *      This is the value that statistical calculations on scores should use
 *
 * TODO: Lock this model so can't be saved or updated or deleted
 *
 * @package App
 */
class Grade extends Model
{
    protected $displayValue;
    protected $calcValue;
    protected $gradeId;

    public function __construct($gradeId, $displayValue, $calcValue)
    {
        $this->attributes['id'] = $gradeId;
        $this->gradeId = $gradeId;

        $this->attributes['display_value'] = $displayValue;
        $this->displayValue = $displayValue;

        $this->attributes['calc_value'] = $calcValue;
        $this->calcValue = $calcValue;
    }


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

<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/22/15
 * Time: 4:27 PM
 */

namespace App\Repositories\Grade;


use App\Grade;

class GradeFactory
{

    public static $grades = [
        ['grade_id' => 100, 'display_value' => 'A+', 'calc_value' => 98],
        ['grade_id' => 101, 'display_value' => 'A', 'calc_value' => 95],
        ['grade_id' => 102, 'display_value' => 'A-', 'calc_value' => 92],
        ['grade_id' => 103, 'display_value' => 'B+', 'calc_value' => 88],
        ['grade_id' => 104, 'display_value' => 'B', 'calc_value' => 85],
        ['grade_id' => 105, 'display_value' => 'B-', 'calc_value' => 82],
        ['grade_id' => 106, 'display_value' => 'C+', 'calc_value' => 78],
        ['grade_id' => 107, 'display_value' => 'C', 'calc_value' => 75],
        ['grade_id' => 108, 'display_value' => 'C-', 'calc_value' => 72],
        ['grade_id' => 109, 'display_value' => 'D+', 'calc_value' => 68],
        ['grade_id' => 110, 'display_value' => 'D', 'calc_value' => 65],
        ['grade_id' => 111, 'display_value' => 'D-', 'calc_value' => 62],
        ['grade_id' => 112, 'display_value' => 'F', 'calc_value' => 55]
    ];

    protected static $searchableGrades = [];

    /**
     * Factory method for grade object
     * Legitimate values are string representations of letter grades A through F with plus/minus modifiers
     * with the form: 'A+', 'A', 'A-'
     *
     * @param string $displayValue
     * @return Grade
     * @throws \Exception
     */
    static public function loadByDisplayValue($displayValue)
    {
        //Load the properties
        $gradeValues = self::getGradeFromDisplayValue($displayValue);

        //Throw exception if couldn't retrieve the display value
        if( empty($gradeValues) ){ throw new \Exception('grade could not be loaded'); }

        //Make and return a new object
        return new Grade($gradeValues['grade_id'], $gradeValues['display_value'], $gradeValues['calc_value']);
    }

    /**
     * Converts the static array into a laravel collection object to
     * make it easily searchable.
     * Called once per run.
     */
    static protected function makeSearchable()
    {
        if( empty(self::$searchableGrades))
        {
            self::$searchableGrades = collect(self::$grades);
        }
    }

    /**
     * Handles the search process
     * @param $displayValue
     * @return mixed
     */
    static protected function getGradeFromDisplayValue($displayValue)
    {
        self::makeSearchable();
        return self::$searchableGrades->where('display_value', $displayValue)->first();
    }

}
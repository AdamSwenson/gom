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

    /** @var array The standardized grades and various associated values in descending order */
    static public $grades = [
        ['grade_id' => 100, 'display_value' => 'A+', 'calc_value' => 98, 'default_cutoff' => 0.97, 'group' => 0, 'ordinal' => 0],
        ['grade_id' => 101, 'display_value' => 'A', 'calc_value' => 95, 'default_cutoff' => 0.93, 'group' => 0, 'ordinal' => 1],

        ['grade_id' => 102, 'display_value' => 'A-', 'calc_value' => 92, 'default_cutoff' => 0.90, 'group' => 0, 'ordinal' => 2],

        ['grade_id' => 103, 'display_value' => 'B+', 'calc_value' => 88, 'default_cutoff' => 0.87, 'group' => 0, 'ordinal' => 3],

        ['grade_id' => 104, 'display_value' => 'B', 'calc_value' => 85, 'default_cutoff' => 0.83, 'group' => 0, 'ordinal' => 4],

        ['grade_id' => 105, 'display_value' => 'B-', 'calc_value' => 82, 'default_cutoff' => 0.80, 'group' => 0, 'ordinal' => 5],

        ['grade_id' => 106, 'display_value' => 'C+', 'calc_value' => 78, 'default_cutoff' => 0.77, 'group' => 0, 'ordinal' => 6],

        ['grade_id' => 107, 'display_value' => 'C', 'calc_value' => 75, 'default_cutoff' => 0.73, 'group' => 0, 'ordinal' => 7],

        ['grade_id' => 108, 'display_value' => 'C-', 'calc_value' => 72, 'default_cutoff' => 0.70, 'group' => 0, 'ordinal' => 8],

        ['grade_id' => 109, 'display_value' => 'D+', 'calc_value' => 68, 'default_cutoff' => 0.67, 'group' => 0, 'ordinal' => 9],

        ['grade_id' => 110, 'display_value' => 'D', 'calc_value' => 65, 'default_cutoff' => 0.63, 'group' => 0, 'ordinal' => 10],

        ['grade_id' => 111, 'display_value' => 'D-', 'calc_value' => 62, 'default_cutoff' => 0.60, 'group' => 0, 'ordinal' => 11],
        ['grade_id' => 112, 'display_value' => 'F', 'calc_value' => 55, 'default_cutoff' => 0.50, 'group' => 0, 'ordinal' => 12]
    ];

    /** @var array The default cutoffs for each possible grade */
    static public $defaultCutoffs = [];

    /** @var array The text to be displayed to the student for each grade */
    static public $displayValues = [];

    /** @var array The value of each grade to be used in calculations of statistics */
    static public $calcValues = [];

    /** @var array Laravel collection of the grades */
    static protected $searchableGrades = [];

    /**
     * Returns grades as a json object for the grading page
     */
    static public function gradeJson()
    {
        $grades = [];
        foreach ( self::$grades as $g ) {
            $grades[] = ['displayValue' => $g['display_value'], 'calcValue' => $g['calc_value']];
        }
        return json_encode($grades, JSON_FORCE_OBJECT);
    }


    /**
     * Each user gets their own set of standard grade values
     * This populates their individual table with their own set.
     * The grades are not shared so that a user could modify the standard
     * set if she chooses
     */
    static public function initializeStandardGrades()
    {

        foreach ( self::$grades as $g ) {
            Grade::create([
                'display_value' => $g['display_value'],
                'calc_value' => $g['calc_value'],
                'default_cutoff' => $g['default_cutoff'],
                'group' => $g['group'],
                'ordinal' => $g['ordinal']
            ]);
        }

    }

    /**
     * Factory method for grade object
     *
     * When grade assignments are saved to the db, they will be stored via
     * the grade_id in self::$grades. This is a method to get a Grade object back
     * based on that stored id.
     * @param $gradeId
     * @return Grade
     */
    static public function loadByGradeId( $gradeId )
    {
        self::makeSearchable();

        $v = self::$searchableGrades->where('grade_id', $gradeId)->first();

        return Grade::find($gradeId);
        //Make and return a new object
//        return new Grade($v['grade_id'], $v['display_value'], $v['calc_value']);
    }

    /**
     * Factory method for grade object
     * Legitimate values are string representations of letter grades A through F with plus/minus modifiers
     * with the form: 'A+', 'A', 'A-'
     *
     * @param string $displayValue
     * @return Grade
     * @throws \Exception
     */
    static public function loadByDisplayValue( $displayValue )
    {
        //Load the properties
        $gradeValues = self::getGradeFromDisplayValue($displayValue);

        //Throw exception if couldn't retrieve the display value
        if ( empty($gradeValues) ) {
            throw new \Exception('grade could not be loaded');
        }

        //Make and return a new object
        return new Grade($gradeValues['grade_id'], $gradeValues['display_value'], $gradeValues['calc_value']);
    }

    /**
     * Factory method which returns a grade object based on the ordinal position of the grades in descending order.
     * Legitimate values are integers from 0 to 12, where:
     *      0 = A+,
     *      1 = A,
     *      2 = A-,
     *      3 = B+,
     *      etc
     * @param integer $order
     * @return Grade
     */
    static public function loadByOrder( $order )
    {
        $gradeValues = self::$grades[$order];
        return new Grade($gradeValues['grade_id'], $gradeValues['display_value'], $gradeValues['calc_value']);
    }

    /**
     * Returns an array of the display values of the grades from highest to lowest (i.e, A+, A, A-, B+ ...)
     * @return array
     */
    static public function getDisplayValuesOfGrades()
    {
        self::buildStaticArrays();
        return self::$displayValues;
    }

    /**
     * Returns an array of the values to be used in calculation for all the standard
     * grades (i.e., the stuff stored in self::$grades).
     * These grades are returned from highest to lowest (i.e, A+, A, A-, B+ ...)
     * @returns array
     */
    static public function getCalcValuesOfGrades()
    {
        self::buildStaticArrays();
        return self::$calcValues;
    }

    /**
     * Returns array of floats representing the default cut offs for each grade to be displayed.
     * These grades are returned from highest to lowest (i.e, A+, A, A-, B+ ...)
     * @return array
     */
    static public function getDefaultCutoffsOfGrades()
    {
        self::buildStaticArrays();
        return self::$defaultCutoffs;
    }

    /**
     * Populates the static arrays if all three are empty
     */
    static protected function buildStaticArrays()
    {
        if ( empty(self::$displayValues) && empty(self::$calcValues) && empty(self::$displayValues) ) {
            foreach ( self::$grades as $g ) {
                self::$calcValues[] = $g['calc_value'];
                self::$defaultCutoffs[] = $g['default_cutoff'];
                self::$displayValues[] = $g['display_value'];
            }
        }
    }

    /**
     * Converts the static array into a laravel collection object to
     * make it easily searchable.
     * Called once per run.
     */
    static protected function makeSearchable()
    {
        if ( empty(self::$searchableGrades) ) {
            self::$searchableGrades = collect(self::$grades);
        }
    }

    /**
     * Handles the search process for lookups using display value
     * @param $displayValue
     * @return mixed
     */
    static protected function getGradeFromDisplayValue( $displayValue )
    {
        self::makeSearchable();

        return self::$searchableGrades->where('display_value', $displayValue)->first();
    }

}
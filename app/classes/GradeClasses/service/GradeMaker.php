<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 10:46 AM
 */

namespace GradeClasses\service;


/**
 * Class GradeMaker
 * Factory for grade objects. Figures out which kind to use
 * @package GradeClasses\service
 */
class GradeMaker 
{

    const CALCULATED = 1;
    const DIRECT = 2;

    public static function factory($type, $displayText=null, $displayNumeric=null, $args=array())
    {
        $instance = self::determineType($type, $args);
        $grade = new \GradeClasses\models\Grade();
        $grade->setDisplayText($displayText);
        $grade->setDisplayNumeric($displayNumeric);
        $instance->setGrade($grade);
        return $instance;
    }


    static protected function determineType($type, $args)
    {
        switch($type)
        {
            case self::CALCULATED:
                $cg = new \GradeClasses\models\CalculatedGrade();
                return self::setCriteria($cg, $args);
                break;
            case self::DIRECT:
                return new \GradeClasses\models\DirectlyAssigned();
                break;
            default:
                throw new \Exception("Invalid type passed in");
        }
    }

    static protected function setCriteria($instance, $args)
    {
        if(!empty($args))
        {
            if(array_key_exists(\GradeClasses\models\CalculatedGrade::MAX_SCORE_KEY, $args))
//            if(isset($args[\GradeClasses\models\CalculatedGrade::MAX_SCORE_KEY]))
            {
                $instance->setMaxScore($args[\GradeClasses\models\CalculatedGrade::MAX_SCORE_KEY]);
            }
            if(array_key_exists(\GradeClasses\models\CalculatedGrade::MIN_SCORE_KEY, $args))
//            isset($args[\GradeClasses\models\CalculatedGrade::MIN_SCORE_KEY]))
            {
                $instance->setMinScore($args[\GradeClasses\models\CalculatedGrade::MIN_SCORE_KEY]);
            }
        }
        return $instance;
    }
}
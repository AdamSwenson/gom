<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 1:58 PM
 */

namespace App\classes\GradeClasses\service;


class GradeValidator
{

    /**
     * Determines whether the grade assignments are transitive
     * @param array $grades IGradeHolder or Grade objects, sorted
     * @return bool
     */
    public function checkTransitive(array $grades)
    {
        for ($i = 0; $i < count($grades) - 1; $i++) {
                if ($grades[$i]->getMinScore() <= $grades[$i + 1]->getMaxScore()) {
                    return false;
                }
        }
        return true;
    }

    /**
     * Checks whether the grade assignment scheme gives all students
     * who have taken the exam a grade
     */
    public function checkAllScoresCovered()
    {
    }


}
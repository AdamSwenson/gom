<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 11:58 AM
 */

namespace GradeClasses\models;

/**
 * Interface IGradeHolder
 *
 * This is the interface for objects which wrap
 * grade (\GradeClasses\models\Grade) objects.
 *
 * These wrapping objects hold things like the grade's criteria
 * or other information in addition to the grade object.
 *
 * The grade object only contains some text for display (e.g., 'A-' or 'good')
 * and a numeric representation (both of which are optional.
 *
 * @package GradeClasses\models
 */
interface IGradeHolder 
{

    public function getGrade();

}
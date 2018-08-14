<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/8/18
 * Time: 11:19 AM
 */

namespace App\Repositories\Exam;


/**
 * Class NewExamRepository
 *
 * This supports exam related tasks for
 * version 2.0.0 and higher.
 *
 * @package App\Repositories\Exam
 */
interface INewExamRepository
{
    /**
     * Creates a brand new exam object for use in
     * the new gradeomatic version 2.0.0 or above
     * @param string $kumiName
     * @return mixed
     */
    public function makeNewExam( $kumiName = 'Group1' );

    /**
     * This locates any exams which have
     * not had any properties changed or other
     * objects associated with them and returns them.
     *
     * @return mixed
     */
    public function getEmptyExams();
}
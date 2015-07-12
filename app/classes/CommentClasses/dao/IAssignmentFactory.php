<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 5:02 PM
 */

namespace CommentClasses\dao;


interface IAssignmentFactory
{

    /**
     * @param \Exam $exam
     */
    public function set_exam(\Exam $exam);


    /**
     * @param \Element $element
     */
    public function set_element(\Element $element);


    /**
     * Loads one of the comment assigning objects
     * @param $type String of either 'missing', 'poor', 'competent', 'excellent'
     * @return \CommentCompetent|\CommentExcellent|\CommentMissing|\CommentPoor
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load($type);

}
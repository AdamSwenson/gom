<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 1:58 PM
 */

namespace CommentClasses\dao;


class AssignmentFactory implements IAssignmentFactory
{

    /** @var  $exam \Exam */
    public $exam;

    /** @var  $element \Element */
    public $element;


    /**
     * @param \Exam $exam
     */
    public function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * @param \Element $element
     */
    public function set_element(\Element $element)
    {
        $this->element = $element;
    }


    /**
     * @param $type String of either 'missing', 'poor', 'competent', 'excellent'
     * @return \CommentCompetent|\CommentExcellent|\CommentMissing|\CommentPoor
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load($type)
    {
        switch($type)
        {
            case 'missing':
                return \CommentMissingQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
                break;
            case 'poor':
                return \CommentPoorQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
                break;
            case 'competent':
                return \CommentCompetentQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
                break;
            case 'excellent':
                return \CommentExcellentQuery::create()->filterByExam($this->exam)->filterByElement($this->element)->findOneOrCreate();
                break;
            default:
                break;
        }
    }
}
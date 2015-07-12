<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/3/15
 * Time: 10:44 AM
 */

namespace CommentClasses\dao;

/**
 * Class CommentLoader
 * DAO for loading comments
 * @package CommentClasses\dao
 */
class CommentLoader 
{

    public function load_for_exam(\Exam $exam)
    {
        $element_assign = \ElementAssignmentQuery::create()
            ->filterByExam($exam)
                ->useQuestionQuery()
                    ->useQuestionAssignerQuery()
                        ->filterByExam($exam)
                    ->endUse()
                ->endUse()
            ->find();
    }

    public function load_all()
    {
        return \ElementQuery::create()->find();
    }
}
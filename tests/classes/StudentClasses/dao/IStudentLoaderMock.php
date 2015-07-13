<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 1:49 PM
 */

namespace StudentClasses\dao;


class IStudentLoaderMock extends \classes\MockParent implements IStudentLoader
{

    public function load_students_by_exam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        return $this->response;
    }
}
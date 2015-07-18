<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/15
 * Time: 3:32 PM
 */

namespace App\classes\ImportExportClasses\dao;


use App\classes\MockParent;

class IImportDaoMock extends MockParent implements IImportDao
{


    public function add_record($sid, $student_name, $kumi_name, $email = false)
    {
        $this->record_call(__FUNCTION__, array($sid, $student_name, $kumi_name, $email));
        $this->called = __FUNCTION__;
        return $this->response;
    }

    public function setExam(\Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($exam));
        $this->called = __FUNCTION__;
        return $this->response;
    }
}
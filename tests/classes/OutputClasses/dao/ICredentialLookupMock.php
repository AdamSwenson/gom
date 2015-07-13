<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 8:01 AM
 */

namespace OutputClasses\dao;


class ICredentialLookupMock extends \classes\MockParent implements ICredentialLookup
{

    public $success;

    public function authenticate($access_token)
    {
        $this->record_call(__FUNCTION__, array($access_token));
        return true;
    }

    /**
     * Returns the student object that has been created
     */
    public function get_student()
    {
        return new \Student();
    }

    public function get_exam()
    {
        return new \Exam();
    }
}
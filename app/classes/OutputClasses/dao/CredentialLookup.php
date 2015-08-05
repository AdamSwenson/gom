<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 7:00 AM
 */

namespace App\classes\OutputClasses\dao;

/**
 * Class CredentialLookup
 * This handles looking up the student and exam from the
 * credentials provided to the student in an emails.
 *
 * @package App\classes\OutputClasses\dao
 */
class CredentialLookup implements ICredentialLookup
{
    protected $student;
    protected $exam;

    public $success = false;

    public function authenticate($access_token)
    {
        try{
            echo $access_token;
            $pid = \PseudoIDQuery::create()->filterByPseudoid($access_token)->findOne();
            if($pid) {
                $this->student = $pid->getStudent();
                $this->exam = $pid->getExam();
                $this->success = true;
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            return false;
        }
    }

    /**
     * Returns the student object that has been created
     */
    public function get_student()
    {
        return $this->student;
    }

    public function get_exam()
    {
        return $this->exam;
    }
}
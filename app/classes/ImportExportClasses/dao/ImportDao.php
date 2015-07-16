<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 3:18 PM
 */

namespace App\classes\ImportExportClasses\dao;


use App\classes\Traits\UserTraits;

class ImportDao
{
    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }


    public function add_record($sid, $student_name, $kumi_name, $email=false)
    {
        try {
            $kumi = \KumiQuery::create()
                ->filterByUser($this->user)
                ->filterByNickname($kumi_name)
                ->filterByYear($this->exam->getExamyear())
                ->findOneOrCreate($this->connection);
            $kumi->save($this->connection);

            //    $student = \StudentQuery::create()->filterBySid($sid)->filterByStudentname($student_name)->findOneOrCreate($this->connection);
            //  $student = new \Student($this->connection);
            //$student->setSid($sid);
            if ($email) {
                $student = \StudentQuery::create()
                    ->filterByUser($this->user)
                    ->filterBySid($sid)
                    ->filterByStudentname($student_name)
                    ->filterByEmail($email)
                    ->findOneOrCreate($this->connection);
//                $student->setEmail($email);
            }else{
                $student = \StudentQuery::create()
                    ->filterByUser($this->user)
                    ->filterBySid($sid)
                    ->filterByStudentname($student_name)
                    ->findOneOrCreate($this->connection);
            }
            $student->save($this->connection);

            $assign = \StudentClassAssignmentQuery::create()
                ->filterByUser($this->user)
                ->filterByKumi($kumi)
                ->filterByStudent($student)
                ->findOneOrCreate($this->connection);
            $assign->save($this->connection);
//            $assign = new \StudentClassAssignment($this->connection);
//            $assign->setStudent($student);
//            $assign->setKumi($kumi);
//            $assign->save($this->connection);

            $exam_assign = \ExamClassAssignmentQuery::create()
                ->filterByUser($this->user)
                ->filterByKumi($kumi)
                ->filterByExam($this->exam)
                ->findOneOrCreate($this->connection);
            $exam_assign->save($this->connection);
//            $exam_assign->setKumi($kumi);
//            $exam_assign->setExam($this->exam);
//            if(isset($this->connection)){
//                $exam_assign->save($this->connection);
//            }else{
//                $exam_assign->save();
//            }
        }catch(\Exception $e)
        {
            array_push($this->errors, array('sid' => $sid, 'student_name' => $student_name));
            throw $e;
        }
    }

}
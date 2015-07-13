<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 10:41 AM
 */

namespace App\classes\ImportExportClasses\StudentUpload;


use Map\StudentTableMap;
use Propel\Runtime\Propel;

class Uploader
{
    public $errors = array();

    /** @var  \App\classes\ImportExportClasses\StudentUpload\IStudentCsvProcessor */
    protected $processor;

    /** @var  \Exam */
    protected $exam;

    protected $connection;

    /**
     * Loads the object which handles validating and processing the csv file
     * @param IStudentCsvProcessor $processor
     */
    public function set_file_processor(\App\classes\ImportExportClasses\StudentUpload\IStudentCsvProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * The exam everything is to be associated with
     * @param \Exam $exam
     */
    public function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Main publicly called method
     * @param \App\classes\RequestClasses\IFileRequest $request
     * @return bool
     */
    public function process(\App\classes\RequestClasses\IFileRequest $request)
    {
        try{
            $this->load_students($request);
            $this->record_students();
            return true;
        }catch(\Exception $e)
        {
            return false;
        }
    }


    /**
     * Handles the loading students
     * TODO: Replace error array with custom exceptions
     * @param \App\classes\RequestClasses\IFileRequest $request
     * @return bool
     * @throws \Exception
     */
    protected function load_students(\App\classes\RequestClasses\IFileRequest $request)
    {
        if($this->processor->process_file($request)){
            if(count($this->processor->students) > 0){
                return true;
            }else{
                array_push($this->errors, "No students loaded from file");
                throw new \Exception();
            }
        }else{
            array_push($this->errors, $this->processor->file_error);
            throw new \Exception();
        }
    }

    /**
     * Iterates through the array of student records and saves students
     * @throws \Exception
     */
    protected function record_students()
    {
        $this->connection = Propel::getWriteConnection(StudentTableMap::DATABASE_NAME);
        try {
            foreach($this->processor->students as $row)
            {
                if(isset($row['email'])){
                    $this->add_record($row['student_id'], $row['student_name'], $row['class_nickname'], $row['email']);
                }else{
                    $this->add_record($row['student_id'], $row['student_name'], $row['class_nickname']);
                }
            }
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    /**
     * Does actual recording of each student.
     * TODO Check whether the email part will lead to duplicate a student if now email added.
     * @param $sid
     * @param $student_name
     * @param $kumi_name
     * @param bool $email
     * @throws \Exception
     */
    public function add_record($sid, $student_name, $kumi_name, $email=false)
    {
        try {
            $kumi = \KumiQuery::create()
                ->filterByNickname($kumi_name)
                ->filterByYear($this->exam->getExamyear())
                ->findOneOrCreate($this->connection);
            $kumi->save($this->connection);

        //    $student = \StudentQuery::create()->filterBySid($sid)->filterByStudentname($student_name)->findOneOrCreate($this->connection);
          //  $student = new \Student($this->connection);
            //$student->setSid($sid);
            if ($email) {
                $student = \StudentQuery::create()
                    ->filterBySid($sid)
                    ->filterByStudentname($student_name)
                    ->filterByEmail($email)
                    ->findOneOrCreate($this->connection);
//                $student->setEmail($email);
            }else{
                $student = \StudentQuery::create()
                    ->filterBySid($sid)
                    ->filterByStudentname($student_name)
                    ->findOneOrCreate($this->connection);
            }
            $student->save($this->connection);

            $assign = \StudentClassAssignmentQuery::create()
                ->filterByKumi($kumi)
                ->filterByStudent($student)
                ->findOneOrCreate($this->connection);
            $assign->save($this->connection);
//            $assign = new \StudentClassAssignment($this->connection);
//            $assign->setStudent($student);
//            $assign->setKumi($kumi);
//            $assign->save($this->connection);

            $exam_assign = \ExamClassAssignmentQuery::create()
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
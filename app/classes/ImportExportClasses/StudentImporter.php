<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace ImportExportClasses;

/**
 * Service class which actually imports the students
 *
 * @author adam
 */
class StudentImporter
{
    use \Traits\DataAccessTraits;
    
    /** @var $kumi \KumiClasses\models\IKumi */
    public $kumi;
    
    /** @var $validated_student \App\classes\ImportExportClasses\StudentImportValidator */
    public $validated_student;
    
    protected $sid;
    protected $studentname;
    protected $classid;
    protected $email;
    /**
     * This associates a student with a particular class if want to add year-speific info later. Not really used now.
     * @var type
     */
    protected $studentInfoID;

    public function set_dataservice(\Interfaces\IDataAccessObject $dataservice) {
        $this->dao = $dataservice;
    }
    
    public function set_class_to_import_into(\KumiClasses\models\IKumi $kumi){
     $this->kumi = $kumi;   
    }
    
    /** @var $errors Array which will hold instances of students who were not inserted */
    public $errors = array();
    
    protected $attempts = 0;
    
    protected $successes = 0;
    
//    /**
//     * This does the actual importing
//     * @todo Add class validator by passing in a kumi
//     * @param \App\classes\ImportExportClasses\StudentImportValidator $valid
//     * @param \KumiClasses                                $class
//     */
//    public function __construct(\App\classes\ImportExportClasses\StudentImportValidator $valid, \KumiClasses\service\LoadKumiByClass $class, $dataservice)
//    {
//$this->dao = $dataservice;
////parent::__construct();
//
//        $this->classID = $class->displayID();
////        $this->classID = $classid;
//        
//    }
    
    
    
    public function add_student(\App\classes\ImportExportClasses\StudentImportValidator $validated_student){
        $student1 = $this->add_to_students($validated_student);
        if($student1){ 
            $student2 = $this->add_to_student_info($student1);
            if($student2){
                $result = $this->add_to_studentsXclasses($student2);
                if((!$result) || ($result === 0)){
                    array_push($this->errors, $validated_student);
                }
            }
            else{
                array_push($this->errors, $validated_student);    
            }
        }
        else{
            array_push($this->errors, $validated_student);
        }
    }

    /**
     * This adds the student to the main students table. It silently fails if the student already exists.
     */
    protected function add_to_students(\App\classes\ImportExportClasses\StudentImportValidator $student)
    {
        //Check whether student already exists in the table
        $this->query = "SELECT * FROM students WHERE sid = :sid";
        $this->vals = array('sid' => $student->valid_sid());
        $this->returnAssocFirst();
        if ($this->cnt == 0) {
        //They are new, so insert them into the table
            $this->query = "INSERT INTO students (sid, studentName, email) VALUES (:sid, :studentName, :email)";
            $this->vals = array('sid' => $student->valid_sid(), 
                'studentName' => $student->valid_studentname(), 
                'email' => $student->valid_email());
            $this->executeQuery();
        }
        return $student;
    }

    /**
     * This adds to the student info table. This is pretty much unused now. Will later allow to add class specific info.
     */
    protected function add_to_student_info(\App\classes\ImportExportClasses\StudentImportValidator $student)
    {
        //check to make sure the student is already in the students table
        $this->query = "SELECT sid FROM students WHERE sid = :sid";
        $this->vals = array('sid' => $this->sid);
        $this->returnAssocFirst();
        if ($this->cnt == 1) {
            $this->query = "INSERT IGNORE INTO studentinfo (sid) VALUES (:sid)";
//                        $this->query = "INSERT INTO studentinfo (sid, academicYear, primaryMajor, secondaryMajor)  VALUES (%s, %s, %s, %s)"
            $this->vals = array('sid' => $student->valid_sid());
            $this->executeQuery();
            $student->set_student_info_id($this->lastInsertID());
            return $student;
                    
        } else {
            //@todo add exception indidicating that call has happened out of order
        }
    }

    /**
     * Assign the student to the class
     */
    protected function add_to_studentsXclasses(\App\classes\ImportExportClasses\StudentImportValidator $student)
    {
        //Check if the student/class combo has already been entered
        $this->query = "SELECT sid, classID FROM studentsXclasses WHERE sid = :sid AND classID = :classID";
        $this->vals = array('sid' => $student->valid_sid(), 'classID' => $this->kumi->displayID());
        $this->returnAssocFirst();
        if ($this->cnt == 0) {
            //New, so insert
            $this->query = "INSERT INTO studentsXclasses (sid, classID, studentInfoID) VALUES (:sid, :classID, :studentInfoID)";
            $this->vals = array('sid' => $student->valid_sid(), 'classID' => $this->kumi->displayID(), 'studentInfoID' => $student->valid_student_info_id());
            $this->executeQuery();
        }
        return $this->cnt;
    }

}

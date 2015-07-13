<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace ImportExportClasses;

/**
 * This contains functions to validate student data upon import. Functions can be used statically or can instantiate to hold the valid info.
 *
 * @author adam
 */
class StudentImportValidator
{
    
    public $validator;
    /**
     * @var int The validated sid
     */
    protected $sid;
    /**
     * @var str The validated name
     */
    protected $studentname;
    /**
     * @var type The validated email address
     */
    protected $email;

    protected $student_info_id;
    
    public function set_validator(\App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner_factory)
    {
        $this->validator = $cleaner_factory;
    }
    
    /**
     * This will validate the record and then pass the valid record on demand
     * @param type $sid
     * @param type $studentname
     * @param type $email
     */
    public function __construct($sid, $studentname, $email)
    {
        $this->set_validator(new \App\classes\SecurityClasses\cleaning\CleanerFactory());
        $this->validate_email($email);
        $this->validate_student_id($sid);
        $this->validate_student_name($studentname);
        if((isset($this->sid)) && isset($this->studentname)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * Getter for the validated sid
     * @return type
     */
    public function valid_sid()
    {
        return $this->sid;
    }
    /**
     * Getter for validated studentname
     * @return str
     */
    public function valid_studentname()
    {
        return $this->studentname;
    }

    /**
     * Getter for email
     * @return str
     */
    public function valid_email()
    {
        return $this->email;
    }
    /**
     * Clean incoming data
     * @param  type $data
     * @return type
     */
//    public static function clean($data)
//    {
//        $data = trim($data);
//        $data = stripslashes($data);
//        $data = htmlspecialchars($data);
//
//        return $data;
//    }

    /**
     * Validator for sid
      * @param type $sid
     */
    public function validate_student_id($sid)
    {
        $this->sid = $this->validator->sanitize($sid, 'integer');
//        $id = self::clean($sid);
//        //This will return a boolean while setting the type
//        $success = settype($id, 'int');
//        if ($success > 0) {
//            return $id;
//        } else {
//            //wasn't a number!
//            //@todo better error handling here
//            echo 'Non numeric entry for student id';
//        }

    }
    /**
     * Validator for student name
     * @todo Make validator for student name
     * @param type $studentname
     */
    public function validate_student_name($studentname)
    {
        $this->studentname = \preg_replace('/[^A-Za-z0-9\s,\.]/', '', $studentname);
    }
    
    public function set_student_info_id($student_info_id){
        $this->student_info_id = $this->validator->sanitize($student_info_id, 'integer');
    }
    
    public function valid_student_info_id(){
        return $this->student_info_id;
    }

    /**
     * Validator for email
     * @param string $dirtyemail
     */
    public function validate_email($dirtyemail)
    {
        $this->email = $this->validator->sanitize($dirtyemail, 'email');
        
//        $email = self::clean($email);
//        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
//            $emailErr = "Invalid email format";
//        }
//
//        return $email;
    }
//    /**
//     * This gets run on the first row of the csv file to ensure that the columns are in the right order
//     * @param array $headers
//     */
//    public static function csv_headers($headers)
//    {
//        $correct_order = array('student_id', 'student_name', 'class_id', 'email');
//        for ($index = 0; $index < count($correct_order); $index++) {
//            $ref = strval($correct_order[$index]);
//            $input = strval($headers[$index]);
//            if ($ref == $input) {
//                return true;
//            } else {
//                return false;
//            }
//         }
//    }
}

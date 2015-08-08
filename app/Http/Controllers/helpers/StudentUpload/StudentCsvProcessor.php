<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\Http\Controllers\helpers\StudentUpload;


/**
 * Handles reading the csv file
 *
 * @author adam
 */
class StudentCsvProcessor implements IStudentCsvProcessor
{
    const FILE_TYPE_ERROR = "The file was not a valid .csv file.";
    const ALL_HEADERS_ERROR = "The columns did not have all the correct headers.";
    const HEADER_ORDER_ERROR = "The columns were in the wrong order";

    public $mandatory_headers = array('last_name', 'first_name', 'student_id');

//    public $mandatory_headers = array( 'class_nickname', 'student_id', 'student_name');

    public $optional_headers = array('email');

    public $correct_order_all = array('last_name', 'first_name', 'student_id', 'email');

    /** @var  String Error description for an error which prevents the file from being used */
    public $file_error;

    public $students = array();

    /**
     * Makes sure that the file has the required headers
     * @param array $headers
     * @return boolean
     */
    public function check_has_mandatory_headers(array $headers) {
        foreach ($this->mandatory_headers as $mandatory) {
            if (!in_array($mandatory, $headers)) {
                $this->file_error = self::ALL_HEADERS_ERROR;
                return FALSE;
            }
            return TRUE;
        }
    }

    /**
     * This gets run on the first row of the csv file to ensure that the columns are in the right order
     * @param array $headers
     * @return boolean Description
     */
    public function check_header_order(array $headers)
    {
        if (count($headers) >= count($this->mandatory_headers)) {
            //$correct_order = array('student_id', 'student_name', 'emails');
            for ($index = 0; $index < count($headers); $index++) {
                $ref = strval($this->correct_order_all[$index]);
                $input = strval($headers[$index]);
                if ($ref !== $input) {
                    $this->file_error = self::HEADER_ORDER_ERROR;
                    return FALSE;
                }
            }
            return TRUE;
        } 
        else {
            $this->file_error = self::ALL_HEADERS_ERROR;
            return FALSE;
        }
    }

    public function process_file($filepath)
    {
        try {
            ini_set('auto_detect_line_endings', TRUE);
//            dd($filepath);
            $file = \fopen($filepath, "r");
//            dd($file);
//            $file = $file_object->openFile('r');
            $i = 0;
            while (($data = \fgetcsv($file, 10000, ",")) !== FALSE) {
                //check the header fields
                if ($i === 0) {
//                    if(!$this->check_has_mandatory_headers($data)){
//                        throw new \Exception();
//                    };
//                    if(!$this->check_header_order($data)){
//                        throw new \Exception();
//                    }
                } 
                else {
                    $student = array(
                        //'class_nickname' => $data[0],
                        'last_name' => $data[0],
                        'first_name' => $data[1],
                        'student_id' =>  $data[2],
                        );
                    if(isset($data[3])){
                        $student['email'] = $data[3];
                    }
                    array_push($this->students, $student);
                }
                $i++;
            }

        } catch (\Exception $e) {
            var_dump($e);
            return false;
        } finally {
            \fclose($file);
            \ini_set('auto_detect_line_endings', FALSE);
       //     var_dump($this->students);
        }
        return true;
    }
}

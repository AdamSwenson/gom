<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace RequestClasses;

/**
 * Gets incoming request and checks for files
 *
 * @author adam
 */
class FileRequest extends Request implements IFileRequest
{

    /** @var $files Array of raw files passed in */
    public $files = array();

    /** @var $filenames Array holding names of files passed in */
    public $filenames = array();

    /**
     * Factory method. Loads the incoming and returns a Request instance
     */
    static public function create()
    {
        $obj = new FileRequest();
        $obj->load_files();
        return $obj;
    }

    /**
     * Captures any files that came in with the request
     */
    public function load_files() {
        if (isset($_FILES) && (count($_FILES) > 0) && ($_FILES["file"]["size"] > 0)) {
            if (count($_FILES) === 1) {
                array_push($this->filenames, $_FILES["file"]["tmp_name"]);
                $this->files = $_FILES;
            } else {
                //add handling if this is ever an issue
                throw new \Exception('unexpected number of files passed in');
            }
        }
    }
    
    /**
     * Checks whether loaded valid files
     * @return boolean
     */
    public function received_files(){
        if(count($this->files) > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
        
    }
    
    /**
     * Checks whether the $_POST array had values
     * @return boolean
     */
    public function received_post(){
        if(count($this->post) > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function load() {
        $this->load_files();
        parent::load();
    }
    
    public function unset_incoming() {
        unset($_FILES);
        parent::unset_incoming();
    }

}

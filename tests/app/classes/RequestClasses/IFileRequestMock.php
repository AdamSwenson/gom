<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 5:19 PM
 */

namespace App\classes\RequestClasses;


class IFileRequestMock extends \classes\MockParent implements IFileRequest
{
    /** @var $files Array of raw files passed in */
    public $files = array();

    /** @var $filenames Array holding names of files passed in */
    public $filenames = array();

    /**
     * Captures any files that came in with the request
     */
    public function load_files()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    /**
     * Checks whether loaded valid files
     * @return boolean
     */
    public function received_files()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }
}
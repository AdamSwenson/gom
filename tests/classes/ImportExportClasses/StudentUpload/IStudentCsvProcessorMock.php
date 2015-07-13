<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 5:12 PM
 */

namespace ImportExportClasses\StudentUpload;


class IStudentCsvProcessorMock extends \classes\MockParent implements IStudentCsvProcessor
{

    public $file_error;

    public $students = array();

    public function check_has_mandatory_headers(array $headers)
    {
        $this->record_call(__FUNCTION__, array($headers));
        return $this->response;
    }

    public function check_header_order(array $headers)
    {
        $this->record_call(__FUNCTION__, array($headers));
        return $this->response;

    }

    public function process_file(\RequestClasses\IFileRequest $request)
    {
        $this->record_call(__FUNCTION__, array($request));
        return $this->response;
    }
}
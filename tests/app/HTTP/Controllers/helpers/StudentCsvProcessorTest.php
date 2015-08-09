<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 5:56 PM
 */

namespace App\Http\Controllers\helpers\StudentUpload;


class StudentCsvProcessorTest extends \TestCase
{
    static public $valid_files = array("tests/test_student_upload_valid.csv");
    static public $invalid_files = array("tests/test_student_upload_invalid.csv");

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentCsvProcessor;

        //$this->request = new \RequestClasses\IFileRequestMock();


    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::check_has_mandatory_headers
     */
    public function testCheck_has_mandatory_headers_all()
    {
        $this->assertTrue($this->object->check_has_mandatory_headers($this->object->correct_order_all));
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::check_has_mandatory_headers
     */
    public function testCheck_has_mandatory_headers_required()
    {
        $this->assertTrue($this->object->check_has_mandatory_headers($this->object->mandatory_headers));
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::check_has_mandatory_headers
     */
    public function testCheck_has_mandatory_headers_false()
    {
        $this->assertFalse($this->object->check_has_mandatory_headers(array_slice($this->object->mandatory_headers,
            1)));
        $this->assertEquals(StudentCsvProcessor::ALL_HEADERS_ERROR, $this->object->file_error);
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::check_header_order
     */
    public function testCheck_header_order()
    {
        $this->assertTrue($this->object->check_header_order($this->object->correct_order_all));
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::check_header_order
     */
    public function testCheck_header_order_false()
    {
        $this->assertFalse($this->object->check_header_order(array_reverse($this->object->correct_order_all)));
        $this->assertEquals(StudentCsvProcessor::HEADER_ORDER_ERROR, $this->object->file_error);
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::process_file
     */
    public function testProcess_file()
    {
        foreach (self::$valid_files as $f) {
            //$this->request->filenames = array($f);
            $this->assertTrue($this->object->process_file($f));
//            $this->assertTrue($this->object->process_file($this->request));
            $this->assertEquals(4, count($this->object->students));
        }
    }

    /**
     * @covers \ImportExportClasses\StudentUpload\IStudentCsvProcessor::process_file
     */
    public function testProcess_file_invalid()
    {
        foreach (self::$invalid_files as $f) {
//            $this->request->filenames = array($f);
            $this->assertFalse($this->object->process_file($f));
//            $this->request->filenames = array($f);
//            $this->assertFalse($this->object->process_file($this->request));
            $this->assertEquals(0, count($this->object->students));
            $this->assertNotEmpty($this->object->file_error);
        }
    }
}
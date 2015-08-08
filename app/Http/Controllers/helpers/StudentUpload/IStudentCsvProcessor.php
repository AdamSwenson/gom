<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 5:10 PM
 */

namespace App\Http\Controllers\helpers\StudentUpload;


interface IStudentCsvProcessor 
{
    public function check_has_mandatory_headers(array $headers);

    public function check_header_order(array $headers);

    public function process_file($request);
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/22/15
 * Time: 12:55 PM
 */
namespace App\Http\Controllers\helpers\validation;

use Illuminate\Http\Request;


/**
 * Handles validation of student records when importing.
 * Usual use is to call validateStudents and then use the data in $this->errorMessages,
 * $this->validRecords, and $this->invalidRecords
 *
 * @package Http\Controllers\helpers\validation
 */
interface IStudentRecordValidator
{
    /**
     * Validates student records in incoming request.
     * If it is valid, adds the row identifier to the $this->validRecords array
     * If not valid, adds the row identifier to the $this->invalidRecords array and
     * adds the applicable error messages to $this->errorMessages.
     * @param Request $request
     */
    public function validateStudents(Request $request);
}
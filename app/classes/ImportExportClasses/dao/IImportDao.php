<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/15
 * Time: 3:30 PM
 */

namespace App\classes\ImportExportClasses\dao;


interface IImportDao
{

    /**
     * Takes a new student record and adds it to the database
     *
     * @param $sid
     * @param $student_name
     * @param $kumi_name
     * @param bool|false $email
     * @throws \Exception
     */
    public function add_record($sid, $student_name, $kumi_name, $email=false);

    public function setExam(\Exam $exam);
}
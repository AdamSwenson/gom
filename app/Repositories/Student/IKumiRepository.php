<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/7/15
 * Time: 5:04 PM
 */
namespace App\Repositories\Student;

use App\Exam;
use App\Kumi;


/**
 * Class KumiRepository
 *
 * Handles database operations for classes. This is named 'kumi', the Japanese for 'class'
 * to avoid weirdness on string evaluation.
 *
 * @package Repositories\Student
 */
interface IKumiRepository
{
    /**
     * Loads a kumi object
     *
     * @param $name
     * @param $year
     * @return Kumi
     */
    public function load($name, $year);

    /**
     * Creates a new class entry or returns the existing entry with the same values.
     * Exam is optional. If set it will associate the kumi with the exam.
     * @param $name
     * @param $year
     * @param null $exam
     * @return Kumi
     */
    public function create($name, $year, $exam=null);

    /**
     * Until we get multiple class functionality working, this
     * will either retrieve the default Kumi already created for
     * the exam or make a new one, save it, and return it.
     *
     * @param Exam $exam
     * @return Kumi
     */
    public function loadOrCreateKumiForExam(Exam $exam);
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 9:47 AM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\Exam;


interface IExamDAO
{
    /**
     * Creates a new exam object, saves it, then returns it
     * @param  integer $year
     * @param string $term
     * @param string $name
     * @return Exam
     * @throws \Exception
     */
    public function save_new_exam($year, $term, $name);

    /**
     * Deletes the exam
     * @param Exam $examId
     * @return mixed|void
     * @internal param Exam $exam
     */
    public function delete_exam($examId);

    /**
     * Load exam by id
     *
     * @param $examId
     * @return mixed
     */
    public function load_exam($examId);

    /**
     * Returns all exams
     */
    public function load_all_exams();

    /**
     * Returns all exams for the class
     * @param $classId
     * @return mixed
     */
    public function load_exams_by_class($classId);

    /**
     * Returns all unlocked exams
     */
    public function load_unlocked_exams();

    /**
     * Marks the exam locked
     * @param $examId
     * @return bool
     */
    public function lock_exam($examId);


    /**
     * Marks the exam unlocked
     * @param $examId
     * @return bool
     * @internal param Exam $exam
     */
    public function unlock_exam($examId);

    /**
     * Marks the exam released
     * @param $examId
     * @return bool
     * @internal param Exam $exam
     */
    public function mark_exam_released($examId);

    /**
     * Marks the exam as unreleased
     * @param $examId
     * @return bool
     */
    public function unmark_exam_released($examId);


}
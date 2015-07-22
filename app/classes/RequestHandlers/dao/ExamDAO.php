<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:14 PM
 */

namespace App\classes\RequestHandlers\dao;


use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;

use App\classes\UserManagement\errors\CredentialsException;
use App\Exam;

use Propel\Runtime\Connection\ConnectionWrapper;

class ExamDAO implements IExamDAO
{

    public $connection = null;

    /** @var  $cleaner ICleanerFactory */
    public $cleaner;

    /**
     * Loads the class which handles cleaning before query
     * @param ICleanerFactory $cleanerFactory
     */
    public function set_cleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
    }



    /**
     * Sets a connection object for use with transactions
     * @param $conn
     * @return mixed|void
     */
    public function set_connection($conn)
    {
        $this->connection = $conn;
    }

    /**
     * Deletes the exam
     * @param Exam $examId
     * @return mixed|void
     * @internal param Exam $exam
     */
    public function delete_exam($examId)
    {
        try{
            $clean_id = $this->cleaner->sanitize($examId, CleanerFactory::INTEGER);
            $toDelete = $this->load_exam($clean_id);
            return $toDelete->delete();
//            return Exam::destroy($clean_id);
        }catch(\Exception $e)
        {
            //error handling
        }
    }

    /**
     * Creates a new exam object, saves it, then returns it
     * @param  integer $year
     * @param string $term
     * @param string $name
     * @param null $classId
     * @return Exam
     * @throws \Exception
     */
    public function save_new_exam($year, $term, $name, $classId=null)
    {
        try
        {
            $year_int = $year;
//            $year_int = $this->cleaner->sanitize($year, CleanerFactory::INTEGER);
            //$clean_term = $this->cleaner->sanitize($term, CleanerFactory::STRING, Exam::MAX_TERM_LENGTH);
            //$clean_name = $this->cleaner->sanitize($name, CleanerFactory::STRING, Exam::MAX_NAME_LENGTH);

            $clean_term = $term;
            $clean_name = $name;
Exam::create([
    'user_id' => 1,
    'term' => $clean_term,
    'name' => $clean_name,
    'year' => $year_int
]);
//            $exam = new Exam();
//            $exam->setYear($year_int);
//            $exam->setTerm($clean_term);
//            $exam->setName($clean_name);
//            $exam->save();
//            return $exam;
        } catch (\Exception $e)
        {
        throw $e;
        }
    }

    /**
     * Load exam by id
     *
     * @param $examId
     * @return mixed
     */
    public function load_exam($examId)
    {
        return Exam::findOrFail($examId);
    }

    /**
     * Returns all exams
     */
    public function load_all_exams()
    {
        return Exam::all();
    }

    /**
     * Returns exams for the class/kumi
     * @param $classId
     */
    public function load_exams_by_class($classId)
    {

    }

    /**
     * Returns all unlocked exams
     */
    public function load_unlocked_exams()
    {
        return Exam::unlocked()->get();
    }

    /**
     * Marks the exam locked
     * @param $examId
     * @return bool
     */
    public function lock_exam($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setLocked(1);
        $exam->save();
    }

    /**
     * Marks the exam unlocked
     * @param $examId
     * @return bool
     */
    public function unlock_exam($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setLocked(0);
        $exam->save();
    }

    /**
     * Marks the exam released
     * @param $examId
     * @return bool
     */
    public function mark_exam_released($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setReleased(1);
        $exam->save();
    }

    /**
     * Marks the exam as unreleased
     * @param $examId
     * @return bool
     */
    public function unmark_exam_released($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setReleased(0);
        $exam->save();
    }

}
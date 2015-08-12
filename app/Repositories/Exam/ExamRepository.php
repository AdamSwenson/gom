<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 1:10 PM
 */

namespace App\Repositories\Exam;
use App\Repositories\Exam\IExamRepository;
use App\Http\Controllers\helpers\cleaning\CleanerFactory;
use App\Http\Controllers\helpers\cleaning\ICleanerFactory;
use App\Exam;


class ExamRepository implements IExamRepository
{

    public $connection = null;

    /** @var  $cleaner ICleanerFactory */
    public $cleaner;

    public function __construct()
    {
        $this->cleaner = app()->make('App\HTTP\Controllers\helpers\cleaning\ICleanerFactory');
    }
//
//    public function __construct(ICleanerFactory $cleaner)
//    {
//        $this->cleaner = $cleaner;
//    }

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
     * @param int $examId
     * @return mixed|void
     */
    public function delete_exam($examId)
    {
        try{
            $clean_id = $this->cleaner->sanitize($examId, CleanerFactory::INTEGER);
            $toDelete = $this->load_exam($clean_id);
            return $this->delete_exam_object($toDelete);
//            return $toDelete->delete();
//            return Exam::destroy($clean_id);
        }catch(\Exception $e)
        {
            //error handling
        }
    }

    /**
     * Deletes the exam
     * @param Exam $exam
     * @return boolean
     */
    public function delete_exam_object(Exam $exam)
    {
        return $exam->delete();
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

            $exam = new Exam();
            $exam->setYear($year_int);
            $exam->setTerm($clean_term);
            $exam->setName($clean_name);
            $exam->save();
            return $exam;
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
     * @param integer $classId
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
        $exam->update();
        return $exam;
    }

    /**
     * Marks the exam unlocked
     * @param integer $examId
     * @return Exam
     */
    public function unlock_exam($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setLocked(0);
        $exam->update();
        return $exam;
    }

    /**
     * Marks the exam released
     * @param integer $examId
     * @return Exam
     */
    public function mark_exam_released($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setReleased(1);
        $exam->update();
        return $exam;
    }

    /**
     * Marks the exam as unreleased
     * @param integer $examId
     * @return Exam
     */
    public function unmark_exam_released($examId)
    {
        $exam = $this->load_exam($examId);
        $exam->setReleased(0);
        $exam->update();
        return $exam;
    }

    /**
     * Updates an exam by examId, saves it, then returns it
     * @param $examId
     * @param  integer $year
     * @param string $term
     * @param string $name
     * @return Exam
     */
    public function update_exam($examId, $year, $term, $name)
    {
        $exam = $this->load_exam($examId);
        return $this->update_exam_object($exam, $year, $term, $name);
    }

    /**
     * Updates an exam object, saves it, then returns it
     * @param Exam $exam
     * @param  integer $year
     * @param string $term
     * @param string $name
     * @return Exam
     */
    public function update_exam_object(Exam $exam, $year, $term, $name)
    {
        $exam->setYear($year);
        $exam->setTerm($term);
        $exam->setName($name);
        $exam->save();
        return $exam;
    }

}
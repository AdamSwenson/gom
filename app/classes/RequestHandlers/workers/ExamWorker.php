<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 1:56 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\RequestHandlers\dao\ExamDAO;
use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\ExamClasses\service\ExamCreator;
use App\classes\ExamClasses\service\LockManager;
use App\classes\ExamClasses\service\ReleaseManager;
use App\classes\PseudoIDClasses\service\ManagerFactory;
use \App\classes\RequestHandlers\workers\IRequestWorker;
use App\classes\RestrictorClasses\dao\RestrictorDAO;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Exam;

class ExamWorker extends IRequestWorker
{
    public $dao;

    public function __construct()
    {
        $this->dao = new ExamDAO();
    }

    public function handle($request)
    {
        $this->loadHelpers();

        switch ($request->task())
        {
            case 'createExam':
                $this->createExam($request);
                break;
            case 'lockExam':
                $this->lockExam($request);
                break;
            case 'unlockExam':
                $this->unlockExam($request);
                break;
            case 'releaseExam':
                $this->releaseExam($request);
                break;
            case 'unreleaseExam':
                $this->unreleaseExam($request);
                break;
            case 'cloneExamination':
                $this->cloneExamination($request);
                break;
            default:
                throw new \Exception('bad request');
        }
    }


    // new methods to handle exam operations

    /**
     * Returns a specific exam by id
     *
     * @param integer $examId
     */
    public function getExam($examId)
    {
        return $this->dao->load_exam($examId);
    }

    /**
     * Return all exams associated with the user.
     * If $classId !== null, return only the exams associated with that class
     *
     * @param null $classId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllExams($classId = null)
    {
        if (!empty($classId))
        {
            return $this->dao->load_exams_by_class($classId);
        }
        else
        {
            return $this->dao->load_all_exams();
        }
    }

    /**
     * Make a new exam
     *
     * @param string $examName
     * @param string|integer $year
     * @param string $term
     * @param string|integer $classId
     *
     * TODO: Should this also set the exam as the currently being used exam?
     * TODO: Add real exception handling
     * @return Exam
     * @throws \Exception
     */
    public function createExam($examName, $year, $term, $classId = null)
    {
        try
        {
            return $this->dao->save_new_exam($year, $term, $examName);
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Delete the specified exam.
     * Note that this deletes all scores and assignments associated with the exam.
     *
     * TODO Add real exception handling.
     *
     * @param integer $examId
     * @return mixed|void
     * @throws \Exception
     */
    public function deleteExam($examId)
    {
        try
        {
            return $this->dao->delete_exam($examId);
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Make exam comments available to students
     * @param $examId
     * @return bool
     */
    public function releaseExam($examId)
    {
        return $this->dao->mark_exam_released($examId);
    }

    /**
     * Makes exam comments no longer available to students
     * @param $examId
     * @return bool
     */
    public function unreleaseExam($examId)
    {
        return $this->dao->unmark_exam_released($examId);
    }

    /**
     * Prevent exam and components from being altered (e.g., after grading or after completely done)
     * @param $examId
     * @return bool
     */
    public function lockExam($examId)
    {
        return $this->dao->lock_exam($examId);
    }

    /**
     * Allow edits on exam and components
     * @param $examId
     * @return bool
     */
    public function  unlockExam($examId)
    {
        return $this->dao->unlock_exam($examId);
    }


    public function cloneExamination($request)
    {
    }
}
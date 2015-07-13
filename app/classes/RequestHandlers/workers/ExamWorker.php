<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 1:56 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\ExamClasses\dao\ExamDAO;
use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\ExamClasses\service\ExamCreator;
use App\classes\ExamClasses\service\LockManager;
use \App\classes\RequestHandlers\workers\IRequestWorker;
use App\classes\RestrictorClasses\dao\RestrictorDAO;

class ExamWorker extends IRequestWorker
{
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

    /**
     * Create new exam and restrictors
     * @param $request
     */
    public function createExam($request)
    {
        $exam_creator = new ExamCreator();
        $exam_creator->set_response_handler($this->response_handler);
        $exam_creator->setCurrentExamManager(new CurrentExamManager());
        $restrictor_dao = new RestrictorDAO();
        $restrictor_dao->set_cleaner($this->cleaner);
        $exam_creator->load_restrictor_dao($restrictor_dao);
        $exam_creator->load_exam_dao(new ExamDAO());
        $exam = $exam_creator->create_exam($request->http);
    }

    public function lockExam($request)
    {
        $lock_manager = new LockManager();
        $lock_manager->set_response_handler($this->response_handler);
        $lock_manager->load_exam_dao(new ExamDAO());
        $lock_manager->execute($request);
        $lock_manager = new LockManager($request);
    }

    public function  unlockExam($request)
    {
        $lock_manager = new LockManager();
        $lock_manager->set_response_handler($this->response_handler);
        $lock_manager->load_exam_dao(new ExamDAO());
        $lock_manager->execute($request);
    }

    public function releaseExam($request)
    {
        $release_manager = new \App\classes\ExamClasses\service\ReleaseManager();
        $release_manager->set_response_handler($this->response_handler);
        $release_manager->load_exam_dao(new ExamDAO());
        $release_manager->set_pseudoID_manager(new \App\classes\PseudoIDClasses\service\ManagerFactory());
        $release_manager->execute($request);
    }

    public function unreleaseExam($request)
    {
        $release_manager = new \App\classes\ExamClasses\service\ReleaseManager();
        $release_manager->set_response_handler($this->response_handler);
        $release_manager->load_exam_dao(new ExamDAO());
        $release_manager->set_pseudoID_manager(new \App\classes\PseudoIDClasses\service\ManagerFactory());
        $release_manager->execute($request);
    }


    public function cloneExamination($request)
    {
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:39 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\ExamClasses\service\NumberExamsManager;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\StudentClasses\service\AutocompleteService;

class InputWorker extends IRequestWorker
{

    public function handle($request)
    {
        $this->loadHelpers();

        switch($request->task())
        {
            case 'setExamID':
                $this->setExamID($request);
                break;
            case 'getAutoSID':
                $this->getAutoSID($request);
                break;
            case 'setTotalExams':
                $this->setTotalExams($request);
                break;
            default:
                throw new \Exception('bad input request');
        }

    }


    /**
     *
     * @throws \Exception
     */
    public function setExamID($request)
    {
        try
        {
            //TODO Return examid in json on success
            $current_exam_manager = new CurrentExamManager();
            $this->exam = $current_exam_manager->set_current_exam($request->http['examID']);

            if (!empty($this->exam))
            {
                $this->response_handler->handle_response(array(
                    'status' => 'success',
                    'examID' => $this->exam->getId()
                ));
            } else
            {
                $this->response_handler->handle_row_count(0);
            }
        } catch (\Exception $exc)
        {
            $this->response_handler->handle_row_count(0);
            $cnt = 0;
            throw new \Exception('Error setting exam ' . $exc->getTraceAsString());
        }

    }

    /**
     * Handles autocomplete request for student id
     * @param $request
     */
    public function getAutoSID($request)
    {
        $autocomplete_handler = new AutocompleteService();
        $autocomplete_handler->set_response_handler($this->response_handler);
        $autocomplete_handler->process($this->exam, $request);
    }


    public function setTotalExams($request)
    {
        $manager = new NumberExamsManager();
        $manager->load_cleaner(new CleanerFactory());
        $manager->set_response_handler($this->response_handler);
        $manager->set_number_exams($request->http['totalExams']);
    }

}
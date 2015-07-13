<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:36 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\TimerClasses\ExamTimerHandler;
use App\classes\TimerClasses\GroupTimerHandler;

class TimeWorker extends  IRequestWorker
{

    public function handle($request)
    {
        $this->loadHelpers();

        switch($request->task())
        {
            case 'getGroupTime':
                $this->getGroupTime($request);
                break;
            case 'setGroupTime':
                $this->setGroupTime($request);
                break;
            case 'getExamTime':
                $this->getExamTime($request);
                break;
            case 'setExamTime':
                $this->setExamTime($request);
                break;
            default:
                throw new \Exception('bad time request');
        }

    }


    public function getGroupTime($request)
    {
        $gt_handler = new GroupTimerHandler();
        $gt_handler->set_response_handler($this->response_handler);
        $gt_handler->get($this->exam, $request->http['groupNumber']);
    }

    public function setGroupTime($request)
    {
        $gt_handler = new GroupTimerHandler();
        $gt_handler->set_response_handler($this->response_handler);
        $gt_handler->update($this->exam, $request->http['groupNumber'], $request->http['toAdd']);
    }

    public function getExamTime($request)
    {
        $student = $this->student_factory->load_from_request($request);
        $et_handler = new ExamTimerHandler();
        $et_handler->set_response_handler($this->response_handler);
        $et_handler->get($this->exam, $student);
    }

    public function setExamTime($request)
    {
        $student = $this->student_factory->load_from_request($request);
        $et_handler = new ExamTimerHandler();
        $et_handler->set_response_handler($this->response_handler);
        $et_handler->update($this->exam, $student, $request->http['toAdd']);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:34 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\JsonOutputClasses\encoders\SendDataJson;
use App\classes\OutputClasses\stats\ExamStats;

class StatsWorker extends  IRequestWorker
{

    public function handle($request)
    {
        $this->loadHelpers();

        switch($request->task())
        {
            case 'getAllStats':
                $this->getAllStats();
                break;
            case 'getElementAverages':
                $this->getElementAverages();
                break;
            case 'getQuestionAverages':
                $this->getQuestionAverages();
                break;
            default:
                throw new \Exception('bad stats request');
        }

    }

    public function getAllStats()
    {
        $r = array(
            array('ppm' => 1.23),
            array('ppm' => 1.3),
            array('ppm' => 2.1),
            array('ppm' => 2.3),
            array('ppm' => 1.1)
        );
        $dummy = array(
            'AveragePPM' => 1.1,
            "avgExam" => 230,
            "gradeRemaining" => 450,
            "gradeElapsed" => 123,
            "workElapsed" => 200,
            "workRemaining" => 500,
            "pctComplete" => 0.45,
            "examsGraded" => 78,
            "examsUngraded" => 89,
            "ppm" => $r
        );
        $this->response_handler->handle_response($dummy);
    }


    public function getElementAverages()
    {
        $exam_stats = new ExamStats();
        $exam_stats->setEncoder(new SendDataJson());
        $exam_stats->averages($this->exam, new \Element());
    }

    public function getQuestionAverages()
    {
        $exam_stats = new ExamStats();
        $exam_stats->setEncoder(new SendDataJson());
        $exam_stats->averages($this->exam, new \Question());
    }

}
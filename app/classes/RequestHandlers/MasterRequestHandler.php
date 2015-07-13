<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:09 PM
 */

namespace App\classes\RequestHandlers;


use App\classes\ExamClasses\service\CurrentExamManager;
use \App\classes\RequestHandlers\workers\ExamWorker;
use \App\classes\RequestHandlers\workers\GradeWorker;
use \App\classes\RequestHandlers\workers\InputWorker;
use \App\classes\RequestHandlers\workers\ItemWorker;
use \App\classes\RequestHandlers\workers\ScoreWorker;
use \App\classes\RequestHandlers\workers\StatsWorker;
use \App\classes\RequestHandlers\workers\TimeWorker;
use Illuminate\Http\Request;

class MasterRequestHandler
{
    const EXAM = 100;
    const QUESTION = 101;
    const ELEMENT = 102;
    const SCORE = 103;
    const SETUP = 104;
    const INPUT = 105;
    const GRADE = 106;
    const TIME = 107;
    const STATS = 108;
    const TAGS = 109;


    /**
     * Loads the appropriate type of object for handling the request
     * and then calls everything necessary to process it.
     *
     * TODO: Update to using Laravel's Request
     *
     * @param $type
     * @param Request $request
     * @throws \Exception
     */
    static public function handle($type, Request $request)
    {
        switch ($type) {
            case self::EXAM:
                $worker = new ExamWorker();
                break;
            case self::QUESTION:
                $worker = new ItemWorker();
                break;
            case self::ELEMENT:
                $worker = new ItemWorker();
                break;
            case self::SCORE:
                $worker = new ScoreWorker();
                break;
            case self::SETUP:
                $worker = new ItemWorker();
                break;
            case self::INPUT:
                $worker = new InputWorker();
                break;
            case self::GRADE:
                $worker = new GradeWorker();
                break;
            case self::TIME:
                $worker = new TimeWorker();
                break;
            case self::STATS:
                $worker = new StatsWorker();
                break;
            default:
                throw new \Exception('invalid handler type requested ');
        }
        if (isset($worker)) {
            $current_exam_manager = new CurrentExamManager();
            $exam = $current_exam_manager->get_current_exam();
            if ($exam) {
                $worker->setExam($exam);
            }

            //Old request holder
            $request = \App\classes\RequestClasses\Request::create();

            $worker->handle($request);
        }
    }

}
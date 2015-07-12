<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 12:59 PM
 */

namespace ExamInfoClasses\service;


class ExamInfoService
{
    public static $types = array('pages', 'notecard', 'completionOrder');

    /** @var  $dao \ExamInfoClasses\dao\IExamInfoDAO */
    public $dao;

    /** @var  $response_handler \JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /**
     * @param \JsonOutputClasses\controllers\IResponseChooser $response_handler
     */
    public function set_response_handler(\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    public function set_dao(\ExamInfoClasses\dao\IExamInfoDAO $exam_info_dao)
    {
        $this->dao = $exam_info_dao;
    }


    public function get(\Exam $exam, \Student $student)
    {
        $result = $this->dao->load($exam, $student);
        $r = array('pages' => $result->getPages(), 'notecard' => $result->getNotecard(), 'completionOrder' => $result->getCompletionorder());
        $this->response_handler->handle_response($r);
    }

    public function update(\Exam $exam, \Student $student, \RequestClasses\IRequest $request)
    {
        if(isset($request->http['type']) && isset($request->http['score']))
        {
            $score = $request->http['score'];
            switch($request->http['type']){
                case 'pages':
                    $result = $this->dao->update_pages($exam, $student, $score);
                    break;
                case 'completionOrder':
                    $result = $this->dao->update_completion_order($exam, $student, $score);
                    break;
                case 'notecard':
                    $result = $this->dao->update_notecard($exam, $student, $score);
                    break;
                default:
                    $this->response_handler->handle_row_count(0);
                    break;
            }
            if(isset($result))
            {
                $this->response_handler->handle_row_count(1);
            }else
            {
                $this->response_handler->handle_row_count(0);
            }
        }
//
//        foreach(self::$types as $t)
//        {
//            if((isset($request->http['type'])) && ($request->http['type'] == $t))
//            {
//                $attempts += 1;
//                $tocall = 'update_' . $t;
//                $result = $this->dao->$tocall($exam, $student, $request->http['score']);
//                if($result)
//                {
//                    $successes += 1;
//                }
//            }
//        }
//        if($attempts === $successes)
//        {
//            $this->response_handler->handle_row_count(1);
//        } else
//        {
//            $this->response_handler->handle_row_count(0);
//        }
    }

}
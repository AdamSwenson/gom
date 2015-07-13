<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 3:16 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\CommentClassesdisplay\OutputComments;
use App\classes\CommentClassesservice\AssignmentProcessor;
use App\classes\CommentClassesservice\StockTextProcessor;
use App\classes\ElementClasses\dao\ElementAssignmentDAO;
use App\classes\JsonOutputClasses\encoders\SendDataJson;
use App\classes\QuestionClasses\dao\QuestionAssignmentDAO;
use App\classes\QuestionClasses\dao\QuestionDAO;
use App\classes\QuestionClasses\service\QuestionAssigner;

class ItemWorker extends IRequestWorker
{

    public function handle($request)
    {
        $this->loadHelpers();
        switch($request->task())
        {
            case 'setUpQuestions':
                $this->setUpQuestions($request);
                break;
            case 'assignElements':
                $this->assignElements($request);
                break;
            case 'setUpComments':
                $this->setUpComments($request);
                break;
            case 'getCurrentExamComments':
                $this->getCurrentExamComments($request);
                break;
            case 'getAllComments':
                $this->getAllComments($request);
                break;
            case 'getElements':
                $this->getElements($request);
                break;
            case 'getStockText':
                $this->getStockText($request);
                break;
            default:
                throw new \Exception('bad item request');
        }
    }


    /**
     * Edit content of questions
     * @param $request
     */
    public function setUpQuestions($request)
    { //edit question contents
        if (isset($this->exam)) {
            $question_assigner = new QuestionAssigner();
            $question_assigner->set_question_dao(new QuestionDAO());
            $question_assigner->set_question_assigner_dao(new QuestionAssignmentDAO());
            $question_assigner->set_response_handler($this->response_handler);
            $question_assigner->record_one($this->exam, $request->http);
        } else {
            error_log("failed for ");
            //TODO: should log the error
            $this->response_handler->handle_row_count(0);
        }
    }

    public function assignElements($request)
    {
    }

    public function setUpComments($request)
    {
        if ($this->exam) {
            $in = $request->http;
            $processor = new AssignmentProcessor();
            $processor->set_response_handler($this->response_handler);
            $processor->process($request->http, $this->exam);
//                $processor->set_factory(new \App\classes\CommentClassesdao\AssignmentFactory());
//                $processor->process_element_assignment($in);
//                $processor->process_stock_text($in);
//                $processor->process_score_assignment($in, $this->exam);
            //          }
        } else {
            $this->response_handler->handle_row_count(0); //send failure
        }
    }

    public function getCurrentExamComments($request)
    {
        $comment_getter = new OutputComments();
        $comment_getter->set_encoder(new SendDataJson());
        $comment_getter->set_loader(new ElementAssignmentDAO());
        $comment_getter->display_for_exam($this->exam);
    }

    public function getAllComments($request)
    {
        $comment_getter = new OutputComments();
        $comment_getter->set_encoder(new SendDataJson());
        $comment_getter->set_loader(new ElementAssignmentDAO());
        $comment_getter->display_all();
    }

    public function getElements($request)
    {
        //Request to refresh the existing elements and comments
    }


    public function getStockText($request)
    {
    }

    public function newStockText($request)
    { //Create new stock text item
        $valence = '';
        $newText = '';
        $processor = new StockTextProcessor();
        $processor->load_cleaner($this->cleaner);
        $processor->response_handler($this->response_handler);
        $processor->save_new_text($newText, $valence);
    }


}
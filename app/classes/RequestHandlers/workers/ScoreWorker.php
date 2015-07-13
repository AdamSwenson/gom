<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:37 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\ExamInfoClasses\dao\ExamInfoDAO;
use App\classes\ExamInfoClasses\service\ExamInfoService;
use App\classes\ScoreClasses\ElementScoreHandler;
use App\classes\ScoreClasses\QuestionScoreHandler;

class ScoreWorker extends IRequestWorker
{

    public function handle($request)
    {

        $this->loadHelpers();

        switch($request->task()){
            case 'getRecord':
                $this->getRecord($request);
                break;
            case 'recordQuestionScore':
                $this->recordQuestionScore($request);
                break;
            case 'recordElementScore':
                $this->recordElementScore($request);
                break;
            case 'getExamInfo':
                $this->getExamInfo($request);
                break;
            case 'recordExamInfo':
                $this->recordExamInfo($request);
                break;
            case 'backupDB':
                $this->backupDB();
                break;
        }
        // TODO: Implement handle() method.
    }

    /**
     * Once autocomplete has been selected, this handles the resulting request for the record
     */
    public function getRecord($request)
    {
        $this->question_factory->set_exam($this->exam);
        $question = $this->question_factory->load_blind($request);
        $student = $this->student_factory->load_from_request($request);
        if (isset($this->exam) && isset($question) && isset($student)) {
            $score_loader = new \App\classes\ScoreClasses\ScoreLoader();
            $score_loader->set_element_score_handler(new ElementScoreHandler());
            $score_loader->set_question_score_handler(new QuestionScoreHandler());
            $scores = $score_loader->load($this->exam, $question, $student);
            $this->response_handler->handle_response($scores);
        }
    }

    /**
     * record an incoming question score
     * @param $request
     */
    public function recordQuestionScore($request)
    {
        $question = $this->question_factory->load($request);
        $student = $this->student_factory->load_from_request($request);
        $question_score_handler = new QuestionScoreHandler();
        $question_score_handler->set_response_handler($this->response_handler);
        $question_score_handler->update($this->exam, $question, $student, $request->http['questionScore']);
    }

    /**
     * record an incoming element score
     * @param $request
     */
    public function recordElementScore($request)
    {
        $element = $this->element_factory->load($request);
        $student = $this->student_factory->load_from_request($request);
        $element_score_handler = new ElementScoreHandler();
        $element_score_handler->set_response_handler($this->response_handler);
        $element_score_handler->update($this->exam, $element, $student, $request->http['elementScore']);
    }

    public function getExamInfo($request)
    {
        $student = $this->student_factory->load_from_request($request);
        $ei_handler = new ExamInfoService();
        $ei_handler->set_dao(new ExamInfoDAO());
        $ei_handler->set_response_handler($this->response_handler);
        $ei_handler->get($this->exam, $student);
    }

    public function recordExamInfo($request)
    {
        $student = $this->student_factory->load_from_request($request);
        $ei_handler = new ExamInfoService();
        $ei_handler->set_dao(new ExamInfoDAO());
        $ei_handler->set_response_handler($this->response_handler);
        $ei_handler->update($this->exam, $student, $request);
    }

    public function backupDB()
    {
    }
}
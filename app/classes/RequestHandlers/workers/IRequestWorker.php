<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:18 PM
 */

namespace App\classes\RequestHandlers\workers;


use \App\classes\ElementClasses\service\ElementFactory;
use \App\classes\JsonOutputClasses\controllers\ResponseChooser;
use \App\classes\QuestionClasses\dao\QuestionAssignmentDAO;
use \App\classes\QuestionClasses\service\QuestionFactory;
use \App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\StudentClasses\service\StudentService;

abstract class IRequestWorker
{
    public $cleaner;
    public $response_handler;
    public $question_factory;
    public $student_factory;
    public $element_factory;
    public $exam;

    abstract public function handle($request);

    public function setExam($exam)
    {
        $this->exam = $exam;
    }

    public function loadHelpers()
    {
        $this->response_handler = new ResponseChooser();
        $this->cleaner = new CleanerFactory();

        $this->question_factory = new QuestionFactory();
        $this->question_factory->set_cleaner($this->cleaner);
        $this->question_factory->set_question_assignment_dao(new QuestionAssignmentDAO());

        $this->student_factory = new StudentService();
        $this->student_factory->set_cleaner($this->cleaner);

        $this->element_factory = new ElementFactory();
        $this->element_factory->set_cleaner($this->cleaner);
    }

}
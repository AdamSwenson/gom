<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 6:03 PM
 */

namespace App\classes\RequestHandlers\workers;

use App\classes\RequestHandlers\dao\IQuestionDAO;
use App\classes\RequestHandlers\dao\QuestionAssignmentDAO;
use App\classes\RequestHandlers\dao\QuestionDAO;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Exam;
use App\Question;

/**
 * Class QuestionWorker
 * Handles all requests related to questions.
 *
 * NOTE: we may need a method to set the order that questions appear
 *
 * @package App\classes\RequestHandlers\workers
 */
class QuestionWorker extends IRequestWorker {

    /** @var  IQuestionDAO */
    public $dao;

    /** @var  IQuestionAssignmentDAO */
    public $assignmentDao;

    public function __construct()
    {
        $this->dao = new QuestionDAO();
        $this->dao->setCleaner(new CleanerFactory());
        $this->assignmentDao = new QuestionAssignmentDAO();

    }


    /**
     * Get a question by its id.
     * @param integer $questionId
     * @return \App\classes\RequestHandlers\dao\Question|Question
     */
    public function getQuestion($questionId)
    {
        return $this->dao->loadQuestionById($questionId);
    }

    /**
     * Return all questions for the user. If classId is specified,
     * return all questions associated with that class.
     *
     * @param null|integer $classId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllQuestions($classId = null)
    {
        if(!empty($classId))
        {
            return $this->dao->loadQuestionsByClassId($classId);
        }else{
            return $this->dao->loadAll();
            //return Question::all();
        }
    }

    /**
     * Make a new question and assign it to an exam
     * @param string $questionName
     * @param string $questionDesc
     * @param integer $order
     * @param integer $examId
     * @return \App\QuestionAssignment
     */
    public function createQuestion($questionName, $questionDesc, $order, $examId)
    {
        $question = $this->dao->createQuestion($questionName, $questionDesc);

        //associate it with the exam
        return $this->assignmentDao->record($examId, $question->getId(), $order);
    }

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param integer $questionId
     * @return int
     */
    public function deleteQuestion($questionId)
    {
     return $this->dao->deleteQuestion($questionId);
    }

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}
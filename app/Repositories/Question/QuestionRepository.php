<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:11 PM
 */

namespace App\Repositories\Question;



use App\HTTP\Controllers\helpers\cleaning\CleanerFactory;
use App\Question;

/**
 * Class QuestionRepository
 *
 * Replaces IQuestionDao
 *
 * @package Repositories\Question
 */
class QuestionRepository implements IQuestionRepository
{
    /** @var ICleanerFactory  */
    public $cleaner;

    public function __construct()
    {
        $this->cleaner = app()->make('App\HTTP\Controllers\helpers\cleaning\ICleanerFactory');
    }


    /**
     * Creates a new question
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function createQuestion($questionName, $questionText)
    {
        $clean_name = $this->cleaner->sanitize($questionName, CleanerFactory::STRING, Question::MAX_NAME_LENGTH);
        $clean_text = $this->cleaner->sanitize($questionText, CleanerFactory::STRING, Question::MAX_TEXT_LENGTH);

        $question = new Question();
        $question->setQuestionName($clean_name);
        $question->setQuestionText($clean_text);
        $question->save();
        return $question;
    }

    /**
     * Updates a question on the basis of its id
     * @param $questionId
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function updateQuestion($questionId, $questionName, $questionText)
    {
        $question = $this->loadQuestionById($questionId);
        $this->updateQuestionObject($question, $questionName, $questionText);
        return $question;
    }

    /**
     * Updates a question when the model has been passed in
     * @param Question $question
     * @param string $questionName
     * @param string $questionText
     * @return Question
     */
    public function updateQuestionObject(Question $question, $questionName, $questionText)
    {
        $clean_name = $this->cleaner->sanitize($questionName, CleanerFactory::STRING, Question::MAX_NAME_LENGTH);
        $clean_text = $this->cleaner->sanitize($questionText, CleanerFactory::STRING, Question::MAX_TEXT_LENGTH);

        $question->setQuestionName($clean_name);
        $question->setQuestionText($clean_text);
        $question->update();
        return $question;
    }

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param integer $questionId
     * @return int
     */
    public function deleteQuestion($questionId)
    {
        $clean_id = $this->cleaner->sanitize($questionId, CleanerFactory::INTEGER);
        if(!empty($clean_id)){
        return Question::destroy($clean_id);
        }
    }

    /**
     * Delete a question from the database (and from any exams it is associated with).
     * Note: Also removes any existing question scores or element scores.
     * @param Question $question
     * @return int
     */
    public function deleteQuestionObject(Question $question)
    {
        return $question->delete();
    }

    /**
     * Load all questions for the user
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function loadAll()
    {
        return Question::all();
    }

    /**
     * Handles getting a new question object. Throws exception if does not exist
     * @param int $questionId
     * @return Question
     */
    public function loadQuestionById($questionId)
    {
        $clean_id = $this->cleaner->sanitize($questionId, CleanerFactory::INTEGER);
        return Question::findOrFail($clean_id);
    }


    public function loadQuestionsByClassId($classId)
    {

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 12:43 PM
 */

namespace App\classes\RequestHandlers\dao;

use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\Question;

/**
 * Class QuestionDAO
 * Handles creation, alteration, and deletion of \App\Question objects
 *
 * @package App\classes\RequestHandlers\dao
 */
class QuestionDAO implements IQuestionDAO
{
    public $cleaner;

    public function __construct()
    {
        $this->cleaner = new CleanerFactory();
    }

    public function setCleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
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
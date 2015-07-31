<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/5/15
 * Time: 4:24 PM
 */

namespace App\classes\ScoreClasses\dao;

use App\classes\Traits\UserTraits;
use Symfony\Component\Finder\Exception\AccessDeniedException;

/**
 * Class ScoreDAO
 * This is the new one stop shop for all score data requests.
 *
 * Usage
 * $question = new Question();
 * $question->setId(5);
 * $element = new Element();
 * $element->setId(5);
 *
 * Get a student's score for a particular question with id = 5
 * $dao = new \ScoreDAO();
 * $dao->setExam($exam);
 * $dao->setStudent($student);
 * $dao->load('question', $question)
 * or
 * $dao->load('question', 5)
 *
 * Get all question scores for every exam on which question (id=5) has been used
 * $dao = new \ScoreDAO();
 * $dao->load('question', $question)
 * or
 * $dao->load('question', 5)
 *
 * Get a student's score for a particular element with id = 5
 * $dao = new \ScoreDAO();
 * $dao->setExam($exam);
 * $dao->setStudent($student);
 * $dao->load('element', $element)
 * or
 * $dao->load('element', 5)
 *
 * Get all scores from every time element (id=5) has been used
 * $dao = new \ScoreDAO();
 * $element = new Element();
 * $element->setId(5);
 * $dao->load('element', $element)
 * or
 * $dao->load('element', 5)
 *
 *
 * @package App\classes\ScoreClasses\dao
 */
class ScoreDAO implements IScoreDAO
{
    const WORKER_QUESTION = 'question';
    const WORKER_ELEMENT = 'element';

    const BY_ALL = 'all';
    const BY_QUESTION_NUMBER = 'questionnumber';

    /** @var  \App\classes\ScoreClasses\dao\ILoader */
    public $worker;

    /** @var  \Student */
    protected $student;

    /** @var  \Exam */
    protected $exam;

    protected $item;

    public $results = array();


    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }
    /**
     * @param \Student $student
     */
    public function setStudent(\Student $student)
    {
        $this->student = $student;
    }

    /**
     * @param \Exam $exam
     */
    public function setExam(\Exam $exam)
    {
        $this->exam = $exam;
    }


    /**
     * Loads score(s)
     * @param $kind \Question | \Element | integer | string(all | questionnumber)
     * @param $by
     * @param bool $arg
     * @return array
     * @throws \Exception
     */
    public function load($kind, $by, $arg = false)
    {
        $this->load_worker($kind);
        $this->execute($by, $arg);

        return $this->results;
    }


    public function record($kind, $arg)
    {
    }

    /**
     * [do not call externally. Only public to help unit testing]
     * @param $kind
     * @throws \Exception
     */
    public function load_worker($kind)
    {
        switch ($kind)
        {
            case self::WORKER_QUESTION:
                $this->worker = new QuestionLoader();
                break;
            case self::WORKER_ELEMENT:
                $this->worker = new ElementLoader();
                break;
            default:
                throw new \Exception('Invalid kind requested');
        }
        if (!empty($this->exam))
        {
            $this->worker->setExam($this->exam);
        }
        if (!empty($this->student))
        {
            $this->worker->setStudent($this->student);
        }
    }

    /**
     * [do not call externally. Only public to help unit testing]
     * @param $by
     * @param bool $arg
     * @throws \Exception
     */
    public function execute($by, $arg = false)
    {
        if (!$this->is_object_request($by))
        {
            if (!$this->is_id_request($by))
            {
                if (!$this->is_string_request($by, $arg))
                {
                    throw new \Exception('invalid action request');
                }
            }
        }
    }

    /**
     * [do not call externally. Only public to help unit testing]
     * @param $by
     * @return bool
     */
    public function is_object_request($by)
    {
        if (($by instanceof \Question) || ($by instanceof \Element))
        {
            $this->results = $this->worker->object($by);

            return true;
        } else
        {
            return false;
        }
    }

    /**
     * [do not call externally. Only public to help unit testing]
     * If an integer has been passed in, treat it as
     * the id of the item to get score for.
     * @param $by
     * @return bool
     * @throws \Exception
     */
    public function is_id_request($by)
    {
        if (is_integer($by))
        {
            switch ($this->worker->type)
            {
                case self::WORKER_QUESTION:
                    $item = \QuestionQuery::create()
                        ->filterByUser($this->user)
                        ->filterById($by)
                        ->findOne();
                    break;

                case self::WORKER_ELEMENT:
                    $item = \ElementQuery::create()
                        ->filterByUser($this->user)
                        ->filterById($by)
                        ->findOne();
                    break;
                default:
                    throw new \Exception();
            }
            $this->check_set($item);
            $this->results = $this->worker->object($item);

            return true;
        } else
        {
            return false;
        }
    }

    /**
     * [do not call externally]
     * @param $by
     * @param bool $arg
     * @return bool
     * @throws \Exception
     */
    public function is_string_request($by, $arg = false)
    {
        $this->check_set($by);
        switch ($by)
        {
            case self::BY_ALL:
                $this->results = $this->worker->all();
                break;

            case self::BY_QUESTION_NUMBER:
                $this->check_set($arg);
                $this->results = $this->worker->question_number($arg);
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * [do not call externally]
     * Checks that the argument being passed in is
     * filled for methods which require a value.
     * @param $arg
     * @return bool
     * @throws \Exception
     */
    protected function check_set($arg)
    {
        if (isset($arg) && !empty($arg))
        {
            return true;
        }
        throw new \Exception('empty required value for request');
    }


    /**
     * Returns an array of element scores for the specified question number
     * @param \Exam $exam
     * @param \Student $student
     * @param $question_number
     * @return array
     */
    public function element_scores_by_question_number(\Exam $exam, \Student $student, $question_number)
    {
        $this->setExam($exam);
        $this->setStudent($student);

        return $this->load(self::WORKER_ELEMENT, self::BY_QUESTION_NUMBER, $question_number);
//        try {
//            $scores = array();
//            $q = \QuestionAssignerQuery::create()
//                ->filterByExam($exam)
//                ->filterByQuestionnumber($question_number)
//                ->findOne();
//            if(!$q){
//                throw new \Exception();
//            }
//            $el_assigns = \ElementAssignmentQuery::create()
//                ->filterByExam($exam)
//                ->filterByQuestion($q->getQuestion())
//                ->orderBySubtask()
//                ->find();
//            if(!$el_assigns){
//                throw new \Exception();
//            }
//            foreach ($el_assigns as $ea) {
//                $el = $ea->getElement();
//                $es = \ElementScoreQuery::create()
//                    ->filterByExam($exam)
//                    ->filterByStudent($student)
//                    ->filterByElement($el)
//                    ->findOne();
//                if(!$es)
//                {throw new \Exception();}
//                array_push($scores, $es);
//            }
//            return $scores;
//        }catch(\Exception $e){}

    }

    /**
     * Loads question scores for a particular question
     * or loads all question scores for the student if the
     * question does not have an id set
     * @deprecated
     * @param \Exam $exam
     * @param \Question $question
     * @param \Student $student
     * @return mixed|\QuestionScore
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function load_question_scores(\Exam $exam, \Student $student, \Question $question)
    {
        if (!empty($question->getId()))
        {
            $question_score_obj = \QuestionScoreQuery::create()
                ->filterByUser($this->user)
                ->filterByExam($exam)
                ->filterByQuestion($question)
                ->filterByStudent($student)
                ->findOneOrCreate();
        } else
        {
            $question_score_obj = \QuestionScoreQuery::create()
                ->filterByUser($this->user)
                ->filterByExam($exam)
                ->filterByStudent($student)
                ->findOneOrCreate();
        }

        return $question_score_obj;
    }
}
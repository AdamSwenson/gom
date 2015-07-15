<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 11:20 AM
 */

namespace App\classes\OutputClasses\service;


use App\classes\CommentClasses\dao\IStockTextDao;
use App\classes\CommentClasses\dao\StockTextDao;
use App\classes\CommentClasses\service\CommentBuilder;
use App\classes\ScoreClasses\dao\IScoreDAO;

class CommentKludge
{
    const FORGOT = "You forgot to....";
    const POOR = "You did not do a very good job of.....";
    const OKAY = "You did an okay job of.....";
    const GOOD = "You a pretty good of.....";
    const GREAT = "You did a great job.....";

    static public $stock = array(
        array('min' => 0.0, 'max' => 0.5, 'text' => self::FORGOT),
        array('min' => 0.6, 'max' => 2.0, 'text' => self::POOR),
        array('min' => 2.1, 'max' => 5.5, 'text' => self::OKAY),
        array('min' => 5.6, 'max' => 7.5, 'text' => self::GOOD),
        array('min' => 7.6, 'max' => 10.0, 'text' => self::GREAT)
    );

    static public $stockAssign = [
        array('min' => 0.0, 'max' => 0.5, 'valence' => StockTextDao::VALENCE_MISSING),
        array('min' => 0.6, 'max' => 2.0, 'valence' => StockTextDao::VALENCE_POOR),
        array('min' => 2.1, 'max' => 5.5, 'valence' => StockTextDao::VALENCE_COMPETENT),
        array('min' => 5.6, 'max' => 7.5, 'valence' => StockTextDao::VALENCE_COMPETENT),
        array('min' => 7.6, 'max' => 10.0, 'valence' => StockTextDao::VALENCE_EXCELLENT)
    ];

    /** @var  IScoreDAO */
    public $dao;

    protected $stockTextDao;

    /**
     * @param mixed $stockTextDao
     */
    public function setStockTextDao(IStockTextDao $stockTextDao)
    {
        $this->stockTextDao = $stockTextDao;
    }

    protected $commentBuilder;

    /**
     * @param mixed $commentBuilder
     */
    public function setCommentBuilder(CommentBuilder $commentBuilder)
    {
        $this->commentBuilder = $commentBuilder;
    }

    /**
     * @param IScoreDAO $dao
     */
    public function setDao(IScoreDAO $dao)
    {
        $this->dao = $dao;
    }


    public function load_comments_for_question(\Exam $exam, \Student $student, $question_number)
    {
        $this->dao->setExam($exam);
        $this->dao->setStudent($student);
        $scores = $this->dao->load('element', 'questionnumber', $question_number);
        //$scores = $this->dao->element_scores_by_question_number($exam, $student, $question_number);
//        $scores = $this->find_scores($exam, $student, $question_number);
        foreach ($scores as $s) {
            $score = $s->getElementscore();
            $stock_comment = $this->loadStock($score);
//            $stock_comment = $this->find_stock($score);
            $txt = $s->getElement()->getCommenttext();
            $new = $this->commentBuilder->build($txt, $stock_comment);
//            $new = $stock_comment . $txt;
            $s->modified_comment = $new;
            $s->getElement()->setCommenttext($new);
        }
        return $scores;
    }

    public function loadStock($score)
    {
        foreach (self::$stockAssign as $row) {
            if (($score >= $row['min']) && ($score <= $row['max'])) {
                return $this->stockTextDao->findByValence($row['valence'], StockTextDao::TYPE_PREPEND);
            }
        }
    }

//    public function find_scores(\Exam $exam, \Student $student, $question_number)
//    {
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
//
//    }

    public function find_stock($score)
    {
        foreach (self::$stock as $row) {
            if (($score >= $row['min']) && ($score <= $row['max'])) {
                return $row['text'];
            }
        }
    }

}
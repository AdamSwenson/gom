<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 11:07 AM
 */

namespace OutputClasses\stats;

/**
 * Class ExamStats
 * Calculates scores for all student exams in an
 * examination
 * @package OutputClasses\stats
 */
class ExamStats 
{
    /** @var  \OutputClasses\stats\IStatsWorker */
    public $worker;

    public $average_array = array();

    /** @var  \JsonOutputClasses\encoders\DirectJsonOutput */
    public $encoder;

    /** @var  \ScoreClasses\dao\ScoreDAO */
    public $score_dao;

    /**
     * @param \ScoreClasses\dao\ScoreDAO $score_dao
     */
    public function setScoreDao($score_dao)
    {
        $this->score_dao = $score_dao;
    }

    /**
     * @param mixed $encoder
     */
    public function setEncoder(\JsonOutputClasses\encoders\DirectJsonOutput $encoder)
    {
        $this->encoder = $encoder;
    }

    protected function choose($item)
    {
        if($item instanceof \Element){
            $this->worker = new ElementStats();
        }
        elseif($item instanceof \Question){
            $this->worker = new QuestionStats();
        }
        $this->worker->setScoreDao($this->score_dao);
    }

    protected function calculate_averages(\Exam $exam, $item)
    {
        $scores = $this->worker->get_scores($exam, $item);
        $n = count($scores);
        if($n > 0){
            $tot = array_sum($scores);
            return $tot / $n;
        }else{
            return null;
        }
    }

    /**
     * Returns averages in a json
     * @param \Exam $exam
     * @param $item
     * @return string
     */
    public function averages(\Exam $exam, $item)
    {
        $this->average_array = array();
        $this->choose($item);
        $items = $this->worker->get_items($exam);
        foreach($items as $item){
            $avg = $this->calculate_averages($exam, $item);
            array_push($this->average_array, array($this->worker->id_key => $item->getId(), $this->worker->avg_key => $avg));
        }
        $this->encoder->encode_and_send($this->average_array);
    }
}
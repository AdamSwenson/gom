<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 10:46 AM
 */

namespace GradeClasses\models;

/**
 * Class CalculatedGrade
 * This holds a grade object along with its criteria
 * @package GradeClasses\service
 */
class CalculatedGrade implements IGradeHolder
{
    const MIN_SCORE_KEY = 'minScore';

    const MAX_SCORE_KEY = 'maxScore';

    /** @var  \GradeClasses\models\Grade */
    protected $grade;

    protected $minScore;

    protected $maxScore;

    public function __call($method, $args)
    {
        return $this->grade->$method($args);
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade(\GradeClasses\models\Grade $grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return mixed
     */
    public function getMinScore()
    {
        return $this->minScore;
    }

    /**
     * @param mixed $minScore
     * @return bool
     */
    public function setMinScore($minScore)
    {
        $this->checkValid($minScore);
        if (!empty($this->maxScore)) {
            if ($this->maxScore >= $minScore) {
                $this->minScore = $minScore;

                return true;
            } else {
                return false;
            }
        }else{
            $this->minScore = $minScore;
            return true;
        }
    }

    /**
     * @return mixed
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param mixed $maxScore
     * @return bool
     */
    public function setMaxScore($maxScore)
    {
        $this->checkValid($maxScore);
        if (!empty($this->minScore)) {
            if ($this->minScore <= $maxScore) {
                $this->maxScore = $maxScore;

                return true;
            } else {
                return false;
            }
        } else {
            $this->maxScore = $maxScore;

            return true;
        }
    }

    protected function checkValid($score)
    {
        if (!is_float($score)) {
            throw new \Exception("invalid score ");
        }
    }

}
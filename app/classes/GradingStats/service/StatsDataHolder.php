<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\GradingStats\service;

/**
 * This holds the statistical data that the dashboard script is expecting
 *
 * @author adam
 */
class StatsDataHolder
{
    public $AveragePPM;
    public $avgExam;
    public $examsGraded;
    public $examsUngraded;
    public $gradeRemaining;
    public $gradeElapsed;

    public $lastExamPPM;

    public $pctComplete;
    public $workRemaining;
    public $workElapsed;
    public $totalGraded;
    public $remainingExams;
    public $ppm = array();

    /**
     * Takes (a potentially partial) array with values corresponding to properties and loads them
     * @param array $data
     */
    public function load_from_array(array $data)
    {
        $refclass = new \ReflectionClass($this);
        foreach ($refclass->getProperties() as $property) {
            $name = (string) $property->name;
            $trim_name = ltrim($name, '$');
            if (isset($data[$trim_name])) {
                $this->$name = $data[$trim_name];
            }
        }
    }

    /**
     * Generates an associative array from its own properties
     *
     * @return array Associative array ready for json encoding
     */
    public function return_array()
    {
        return get_object_vars($this);
    }

}

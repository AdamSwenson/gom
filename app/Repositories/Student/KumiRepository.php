<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/7/15
 * Time: 4:57 PM
 */

namespace App\Repositories\Student;

use App\Exam;
use App\Kumi;

/**
 * Class KumiRepository
 *
 * Handles database operations for classes. This is named 'kumi', the Japanese for 'class'
 * to avoid weirdness on string evaluation.
 *
 * @package Repositories\Student
 */
class KumiRepository implements IKumiRepository
{

    /**
     * Loads a kumi by its name and year
     * @param $name
     * @param $year
     * @return mixed
     */
    public function load($name, $year)
    {
        return Kumi::where('nickname', $name)->where('year', $year)->first();
    }

    /**
     * Creates a new class entry or returns the existing entry with the same values
     * @param $name
     * @param $year
     * @return Kumi
     */
    public function create($name, $year, $exam=null)
    {
        if(! is_null($exam)){
            //Only uses the first associated kumi
            $preExisting = $exam->classes()->first();
        }else{
            //load by exam name
            $preExisting = $this->load($name, $year);
        }

        if(!empty($preExisting))
        {
            return $preExisting;
        }else{
            $kumi = new Kumi();
            $kumi->nickname = $name;
            $kumi->year = $year;
            $kumi->save();
            if(!empty($exam))
            {
                $kumi->exams()->attach($exam->getId());
            }
            return $kumi;
        }
    }

    /**
     * Until we get multiple class functionality working, this
     * will either retrieve the default Kumi already created for
     * the exam or make a new one, save it, and return it.
     * 
     * @param Exam $exam
     * @return Kumi
     */
    public function loadOrCreateKumiForExam(Exam $exam)
    {
        //Only uses the first associated kumi
        $kumi = $exam->classes()->first();

        //If we already have a kumi for the exam, load it. Otherwise make one.
        //$kumi = $this->load($exams->getName(), $exams->getYear());
        if (!$kumi)
        {
            $kumi = $this->create($exam->getName(), $exam->getYear(), $exam);
        }
        return $kumi;
    }

}
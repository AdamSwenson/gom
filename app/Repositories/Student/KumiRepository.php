<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/7/15
 * Time: 4:57 PM
 */

namespace App\Repositories\Student;

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

    public function load($name, $year)
    {
        return Kumi::where('nickname', $name)->where('year', $year)->first();

//        $uid = Auth::user()->id;
//        $nickname= $exam->name;
//        $year = $exam->year;
//
//        $kumi = Kumi::firstOrCreate(
//            [
//                'user_id' => $uid,
//                'nickname' => $nickname,
//                'year' => $year
//            ]);
//        var_dump($kumi);

    }

    /**
     * Creates a new class entry or returns the existing entry with the same values
     * @param $name
     * @param $year
     * @return Kumi
     */
    public function create($name, $year, $exam=null)
    {
        $preExisting = $this->load($name, $year);
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

}
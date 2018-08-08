<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/8/18
 * Time: 11:06 AM
 */

namespace App\Repositories\Exam;

use App\Exam;
use App\Kumi;

/**
 * Class NewExamRepository
 *
 * This supports exam related tasks for
 * version 2.0.0 and higher.
 *
 * @package App\Repositories\Exam
 */
class NewExamRepository implements INewExamRepository
{


    /**
     * Creates a brand new exam object for use in
     * the new gradeomatic version 2.0.0 or above
     * @param string $kumiName
     * @return Exam
     */
    public function makeNewExam( $kumiName = 'Group1' )
    {
        $exam = Exam::create();
        //this is a brand new exam, so there are no
        //kumis associated with it. So we create
        //and empty one to be the default kumi
        $kumi = Kumi::create(['name' => $kumiName]);
        $kumi->is_roster = true; //make it the default roster
        $exam->kumis()->attach($kumi->id);
        $kumi->save();
        return $exam;
    }


    /**
     * This locates any exams which have
     * not had any properties changed or other
     * objects associated with them and returns them.
     *
     * Exams in the returned array will meet all the
     * following conditions:
     *     Properties are all default
     *     No associated items
     *     No associated kumis or students
     *     No associated notes

     * @return array
     */
    public function getEmptyExams()
    {
        $emptyExams = [];
        $exams = Exam::where('name', null)
            ->where('public_name', null)
            ->where('year', null)
            ->where('term', null)
            ->where('description', null)
            ->doesntHave('assignments')//no items
            ->doesntHave('notes')//no notes
            ->withCount('kumis')
            ->get();

        if ( !is_null($exams) ) {

            //if exams passed the above checks
            //we need to test each one for kumis and students
            foreach ( $exams as $e ) {
                //every exam will have one kumi, if it has any more
                //we're not interested in it
                if ( $e->kumis_count === 1 ) {
                    //now check if there are any students
                    $students = $e->roster()->students()->first();
                    if ( is_null($students) ) {
                        array_push($emptyExams, $e);
                    }
                }
            }
        }

        return $emptyExams;
    }
}
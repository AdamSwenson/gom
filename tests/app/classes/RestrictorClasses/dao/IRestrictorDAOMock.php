<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 1:32 PM
 */

namespace App\classes\RestrictorClasses\dao;


class IRestrictorDAOMock extends \classes\MockParent implements IRestrictorDAO
{

    /**
     * @param $year_string String of the year
     * @return \Year
     */
    public function load_year($year_string)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($year_string));
        return new \Year();
    }

    /**
     * @param $term_string String of term
     * @return \Term
     */
    public function load_term($term_string)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($term_string));
        return new \Term();
    }

    /**
     * @param $examTopic String of exam topic
     * @return \Topic
     */
    public function load_topic($examTopic)
    {
        $caller = __FUNCTION__;
        $this->record_call($caller, array($examTopic));
        return new \Topic();
    }
}
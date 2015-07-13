<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 10:25 AM
 */

namespace App\classes\RestrictorClasses\dao;


interface IRestrictorDAO
{

    /**
     * @param $year_string String of the year
     * @return \Year
     */
    public function load_year($year_string);


    /**
     * @param $term_string String of term
     * @return \Term
     */
    public function load_term($term_string);


    /**
     * @param $examTopic String of exam topic
     * @return \Topic
     */
    public function load_topic($examTopic);
}
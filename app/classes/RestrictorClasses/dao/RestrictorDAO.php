<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 1:17 PM
 */

namespace RestrictorClasses\dao;

/**
 * Class RestrictorDAO
 *
 * Contains functions which check if a restrictor already exists in db
 * If so, loads an object from the db and returns. If not, creates an object and returns
 * (but does not save to db)
 *
 * @package classes\RestrictorClasses
 */
class RestrictorDAO implements IRestrictorDAO
{
    /** @var  $cleaner \SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    public function set_cleaner(\SecurityClasses\cleaning\ICleanerFactory $cleanerFactory){
        $this->cleaner = $cleanerFactory;
    }

    /**
     * @param $year_string String of the year
     * @return \Year
     * @throws \Exception
     */
    public function load_year($year_string)
    {
        $year_int = $this->cleaner->sanitize($year_string, 'integer');
        if(!$year_int) {
            throw new \Exception("inproper input to load_year");
        }
        $year = \YearQuery::create()->filterByPrimaryKey($year_int)->findOneOrCreate();
        return $year;
    }

    /**
     * @param $term_string String of term
     * @return \Term
     * @throws \Exception
     */
    public function load_term($term_string)
    {
        $ts = $this->cleaner->sanitize($term_string, 'string');
        if(!$ts) {
           throw new \Exception("inproper input to load_term");
        }
        $term = \TermQuery::create()->filterByPrimaryKey($ts)->findOneOrCreate();
        return $term;
    }

    /**
     * @param $examTopic String of exam topic
     * @return \Topic
     * @throws \Exception
     */
    public function load_topic($examTopic)
    {
        $ts = $this->cleaner->sanitize($examTopic, 'string');
        if(!$ts) {
            throw new \Exception("inproper input to load_topic");
        }
        $topic = \TopicQuery::create()->filterByPrimaryKey($ts)->findOneOrCreate();
        return $topic;
    }

}
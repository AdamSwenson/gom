<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/1/15
 * Time: 10:36 AM
 */

namespace PseudoIDClasses\service;

use Propel\Runtime\Connection\ConnectionWrapper;

/**
 * Class RemovalManager
 * Handles removing pseudoIDs
 * @package PseudoIDClasses\service
 */
class RemovalManager implements IManager
{

    /** @var  $dao \PseudoIDClasses\dao\IPseudoIDDao */
    protected $dao;

    /**
     * Set the db access object
     * @param \PseudoIDClasses\dao\IPseudoIDDao $dao
     */
    public function load_dao(\PseudoIDClasses\dao\IPseudoIDDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * This is here for use outside of being called by factory interface
     * @param \Exam $exam
     * @return mixed
     */
    public function remove_all_for_exam(\Exam $exam)
    {
        return $this->dao->remove_all_for_exam($exam);
    }

    /**
     * This is the method called via the manager factory interface
     * @param ConnectionWrapper $conn
     * @param \Exam $exam
     * @return int
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function execute(ConnectionWrapper $conn, \Exam $exam)
    {
        return \PseudoIDQuery::create()->filterByExam($exam)->delete($conn);
    }

}
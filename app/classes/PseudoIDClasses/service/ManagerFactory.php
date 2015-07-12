<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/1/15
 * Time: 10:41 AM
 */

namespace PseudoIDClasses\service;


use Propel\Runtime\Connection\ConnectionWrapper;

/**
 * Class ManagerFactory
 * This creates the relevant service class and calls it to
 * act.
 * @package PseudoIDClasses\service
 */
class ManagerFactory implements IManagerFactory
{
    /** @var  \PseudoIDClasses\service\IManager */
    public $worker;

    public function create_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->worker = new \PseudoIDClasses\service\CreationManager();
        $this->worker->load_student_dao(new \StudentClasses\dao\StudentLoader);
        $this->worker->load_id_maker(new \PseudoIDClasses\service\PseudoIDMaker);
        $this->worker->execute($conn, $exam);
    }

    public function remove_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->worker = new \PseudoIDClasses\service\RemovalManager();
        $this->worker->execute($conn, $exam);
    }
}
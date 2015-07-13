<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/1/15
 * Time: 10:41 AM
 */

namespace App\classes\PseudoIDClasses\service;


use Propel\Runtime\Connection\ConnectionWrapper;

/**
 * Class ManagerFactory
 * This creates the relevant service class and calls it to
 * act.
 * @package App\classes\PseudoIDClasses\service
 */
class ManagerFactory implements IManagerFactory
{
    /** @var  \App\classes\PseudoIDClasses\service\IManager */
    public $worker;

    public function create_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->worker = new \App\classes\PseudoIDClasses\service\CreationManager();
        $this->worker->load_student_dao(new \App\classes\StudentClasses\dao\StudentLoader);
        $this->worker->load_id_maker(new \App\classes\PseudoIDClasses\service\PseudoIDMaker);
        $this->worker->execute($conn, $exam);
    }

    public function remove_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->worker = new \App\classes\PseudoIDClasses\service\RemovalManager();
        $this->worker->execute($conn, $exam);
    }
}
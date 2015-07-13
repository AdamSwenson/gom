<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/1/15
 * Time: 11:04 AM
 */

namespace App\classes\PseudoIDClasses\service;

use Propel\Runtime\Connection\ConnectionWrapper;

/**
 * Interface IManager
 * Interface for workers of ManagerFactory
 * @package App\classes\PseudoIDClasses\service
 */
interface IManager 
{

    /**
     * This is the method called via the manager factory interface
     * @param ConnectionWrapper $conn
     * @param \Exam $exam
     * @return mixed
     */
    public function execute(ConnectionWrapper $conn, \Exam $exam);

}
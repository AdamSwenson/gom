<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 5:38 AM
 */

namespace PseudoIDClasses\service;

use Propel\Runtime\Connection\ConnectionWrapper;


interface IManagerFactory
{

    public function create_pseudoIDs(ConnectionWrapper $conn, \Exam $exam);

    public function remove_pseudoIDs(ConnectionWrapper $conn, \Exam $exam);
}
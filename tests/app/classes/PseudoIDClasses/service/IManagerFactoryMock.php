<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/2/15
 * Time: 6:46 AM
 */

namespace App\classes\PseudoIDClasses\service;


use App\classes\MockParent;
use Propel\Runtime\Connection\ConnectionWrapper;

class IManagerFactoryMock extends MockParent implements IManagerFactory
{

    public function create_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($conn, $exam));
        return $this->response;
    }

    public function remove_pseudoIDs(ConnectionWrapper $conn, \Exam $exam)
    {
        $this->record_call(__FUNCTION__, array($conn, $exam));
        return $this->response;
    }
}
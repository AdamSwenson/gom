<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/22/17
 * Time: 1:18 AM
 */

namespace App\Repositories\Assignment;

use App\Exam;

interface IAssignmentRepository
{
    /**
     * expected format of incoming is a list of nodes
     * with the form
     * Node = {
     * id: id, //the item id of the question or element
     * parent: id //the item id of this item's parent
     * children: []
     * }
     * @param Exam $exam
     * @param $incoming
     */
    public function processIncoming( Exam $exam, $incoming );
}
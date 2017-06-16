<?php
namespace App;

use Franzose\ClosureTable\Models\ClosureTable;

class AssignmentClosure extends ClosureTable implements AssignmentClosureInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignment_closure';
}

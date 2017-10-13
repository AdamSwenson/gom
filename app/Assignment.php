<?php
namespace App;

use Franzose\ClosureTable\Models\Entity;

class Assignment extends Entity implements assignmentInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignments';

    /**
     * ClosureTable model instance.
     *
     * @var assignmentClosure
     */
    protected $closure = 'App\assignmentClosure';

    protected $fillable = ['item_id', 'parent_id', 'exam_id' ,'position',  'depth'];

    public function exam(){
        return $this->belongsTo(Exam::class );
    }

    public function item(){
        return $this->belongsTo(Item::class );

    }

}

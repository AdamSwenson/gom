<?php
namespace App;

use Franzose\ClosureTable\Models\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Assignment extends Entity implements AssignmentInterface
{
    use HasFactory;

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
    protected $closure = 'App\AssignmentClosure';

    protected $fillable = ['item_id', 'parent_id', 'exam_id' ,'position',  'depth'];

    public function exam(){
        return $this->belongsTo(Exam::class );
    }

    public function item(){
        return $this->belongsTo(Item::class );

    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assignments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->integer('position', false, true);
            $table->integer('real_depth', false, true);
            $table->integer('exam_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('assignments')->onDelete('set null');

            //one item instance per exam
//            $table->unique(['item_id', 'exam_id']);

//            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('assignments', function(Blueprint $table)
        {
            Schema::dropIfExists('assignments');
        });
    }
}

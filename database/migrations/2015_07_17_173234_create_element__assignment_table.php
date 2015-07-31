<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_assignments', function (Blueprint $table)
        {
            $table->increments('id');
//            $table->integer('owner_id')->unsigned();
            $table->integer('question_assignment_id')->unsigned();
            $table->integer('element_id')->unsigned();
            $table->integer('subtask')->unsigned();
            $table->timestamps();

            $table->unique(['question_assignment_id', 'subtask'], 'el_assign_unique');
//            $table->unique(['owner_id', 'question_assignment_id', 'subtask'], 'el_assign_unique');
//
//            $table->foreign('owner_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');

            $table->foreign('element_id')
                ->references('id')
                ->on('elements')
                ->onDelete('cascade');

            $table->foreign('question_assignment_id')
                ->references('id')
                ->on('question_assignments')
                ->onDelete('cascade');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('element_assignments');
    }
}

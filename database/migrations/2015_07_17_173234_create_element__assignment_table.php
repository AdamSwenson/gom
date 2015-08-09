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
            $table->integer('exam_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('element_id')->unsigned();
            $table->integer('subtask')->unsigned();
            $table->timestamps();

            //Each question cannot have two elements assigned to the same subtask on the same exam
            $table->unique(['exam_id', 'question_id', 'subtask'], 'el_assign_unique');

            //Deleting the exam will delete the element assignment
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');

            //If there is no element to be assigned, then the assignment should go too.
            $table->foreign('element_id')
                ->references('id')
                ->on('elements')
                ->onDelete('cascade');

            //Deleting the question will destroy the element assignment. Moving the question will not
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
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

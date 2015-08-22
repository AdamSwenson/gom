<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_assignments', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('owner_id')->unsigned();
            $table->integer('exam_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('question_number')->unsigned();
            $table->timestamps();

            $table->unique(['exam_id', 'question_number']);
            //TODO Consider re-adding the prohibition on the same question appearing twice on exam
            $table->unique(['exam_id', 'question_id']);



//            $table->unique(['owner_id', 'exam_id', 'question_number']);
//            $table->unique(['owner_id', 'exam_id', 'question_id']);

//            $table->foreign('owner_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');

            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');

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
        Schema::drop('question_assignments');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('questions') && Schema::hasTable('question_assignments'))
        {
            Schema::create('question_scores', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->integer('question_assignment_id')->unsigned()->index();
                $table->integer('student_id')->unsigned()->index();
                $table->float('score')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'question_assignment_id', 'student_id']);

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('question_assignment_id')
                    ->references('id')
                    ->on('question_assignments')
                    ->onDelete('cascade');

                $table->foreign('student_id')
                    ->references('id')
                    ->on('students')
                    ->onDelete('cascade');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_scores');

    }
}

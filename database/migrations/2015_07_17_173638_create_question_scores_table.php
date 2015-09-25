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
                $table->integer('question_assignment_id')->unsigned()->index();
                $table->integer('student_id')->unsigned()->index();
                $table->float('score')->nullable();
                $table->boolean('is_custom')->default(false);
                $table->timestamps();

                $table->unique(['question_assignment_id', 'student_id']);

                $table->foreign('question_assignment_id')
                    ->references('id')
                    ->on('question_assignments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->foreign('student_id')
                    ->references('id')
                    ->on('students')
                    ->onUpdate('cascade')
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

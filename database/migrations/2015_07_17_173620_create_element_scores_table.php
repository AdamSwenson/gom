<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('elements') && Schema::hasTable('element_assignments'))
        {
            Schema::create('element_scores', function (Blueprint $table)
            {
                $table->increments('id');
//                $table->integer('owner_id')->unsigned();
                $table->integer('element_assignment_id')->unsigned();
                $table->integer('student_id')->unsigned();
                $table->float('score')->nullable();
                $table->timestamps();

                $table->unique(['element_assignment_id', 'student_id'], 'elassign_unique');
//                $table->unique(['owner_id', 'element_assignment_id', 'student_id'], 'elassign_unique');
//
//                $table->foreign('owner_id')
//                    ->references('id')
//                    ->on('users')
//                    ->onDelete('cascade');

                $table->foreign('element_assignment_id')
                    ->references('id')
                    ->on('element_assignments')
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
        Schema::drop('element_scores');
    }
}

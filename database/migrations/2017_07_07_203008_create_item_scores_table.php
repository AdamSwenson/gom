<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_scores', function ( Blueprint $table ) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('exam_id')->unsigned();

            $table->float('score')->nullable();
            $table->text('comment_text')->nullable();

            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(['exam_id', 'item_id', 'student_id'], 'its_unique');

            $table->foreign('exam_id')
                ->references('id')
                ->on('exams');
//                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items');


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students');
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_scores');
    }
}

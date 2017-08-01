<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('exam_note') ) {
            Schema::create('exam_note', function ( Blueprint $table ) {
                $table->increments('id');
                $table->integer('exam_id')->unsigned();
                $table->integer('note_id')->unsigned();
                $table->timestamps();

                $table->foreign('exam_id')
                    ->references('id')
                    ->on('exams')
                    ->onDelete('cascade');

                $table->foreign('note_id')
                    ->references('id')
                    ->on('notes')
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
        Schema::dropIfExists('exam_note');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('exam_tag') ) {
            Schema::create('exam_tag', function ( Blueprint $table ) {
                $table->increments('id');
                $table->integer('tag_id')->unsigned();
                $table->integer('exam_id')->unsigned();
                $table->timestamps();

                $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('cascade');

                $table->foreign('exam_id')
                    ->references('id')
                    ->on('exams')
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
        Schema::dropIfExists('exam_tag');
    }
}

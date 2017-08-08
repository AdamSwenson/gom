<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('student_tag') ) {
            Schema::create('student_tag', function ( Blueprint $table ) {
                $table->increments('id');
                $table->integer('student_id')->unsigned();
                $table->integer('tag_id')->unsigned();
                $table->timestamps();

                $table->foreign('student_id')
                    ->references('id')
                    ->on('students')
                    ->onDelete('cascade');

                $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
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
        Schema::dropIfExists('student_tag');

    }
}

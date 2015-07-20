<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKumiStudentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kumi_student', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kumi_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->timestamps();

//            $table->unique(['kumi_id', 'student_id']);
            $table->foreign('kumi_id')
                ->references('id')
                ->on('kumis')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
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
        Schema::drop('kumi_student');
    }


}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccessKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && Schema::hasTable('exams') && Schema::hasTable('students'))
        {
            Schema::create('access_keys', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->string('access_key')->index();
                $table->integer('student_id')->unsigned()->index();
                $table->integer('exam_id')->unsigned()->index();
                $table->boolean('email_sent')->default(0);
                $table->date('access_expires')->nullable();
                $table->timestamps();

                $table->unique(['student_id', 'exam_id']);

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('exam_id')
                    ->references('id')
                    ->on('exams')
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
        Schema::drop('access_keys');
    }
}

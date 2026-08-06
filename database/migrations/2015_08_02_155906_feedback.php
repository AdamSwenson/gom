<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Feedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('access_key')->unique()->index();
            $table->json('content');
            $table->timestamps();

//            $table->primary('access_key');

//            $table->foreign('access_key')
//                ->references('access_key')
//                ->on('access_keys')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feedback');
        //
    }
}

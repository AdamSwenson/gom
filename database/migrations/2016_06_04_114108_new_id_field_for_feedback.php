<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewIdFieldForFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table)
        {
            //add an id column
            $table->increments('id');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table)
        {
//
//            $table->dropIfExists('id');
        });
    }
}
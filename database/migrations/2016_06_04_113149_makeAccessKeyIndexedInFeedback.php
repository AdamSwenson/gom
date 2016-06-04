<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAccessKeyIndexedInFeedback extends Migration
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
//            $table->index('access_key');
            
        });
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

//            $table->dropIfExists('id');
        });
    }
}

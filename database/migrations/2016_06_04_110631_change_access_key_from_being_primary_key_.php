<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAccessKeyFromBeingPrimaryKey extends Migration
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
            $table->dropPrimary('access_key');
            //make access_key unique and an index
            $table->unique('access_key');

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
            $table->dropPrimary('access_key');
        });
    }
}

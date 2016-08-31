<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQueueReservedAtToJobsForLaravel53 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if ( Schema::hasTable('jobs') )
        {
            Schema::table('jobs', function (Blueprint $table)
            {
                                $table->index(['queue', 'reserved_at']);
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
        //
    }
}

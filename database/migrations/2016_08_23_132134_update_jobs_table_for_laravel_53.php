<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJobsTableForLaravel53 extends Migration
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
//                /*
//                 * If you are using the database driver, you should drop the jobs_queue_reserved_reserved_at_index index
//                 * then drop the reserved column from your jobs table.
//                 */
                $table->dropIndex('jobs_queue_reserved_reserved_at_index');
                $table->dropIfExists('reserved');
//                /* This column is no longer required when using the
//                * database driver. Once you have completed these changes, you should add a new compound index on the
//                * queue and reserved_at column.
//                */
//                $table->index(['queue', 'reserved_at']);
//                //
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
//        if ( Schema::hasTable('jobs') )
//        {
//            Schema::table('jobs', function (Blueprint $table)
//            {
//                $table->tinyInteger('reserved')->unsigned();
//                $table->index(['queue', 'reserved', 'reserved_at']);
//            });
//        }
    }
}
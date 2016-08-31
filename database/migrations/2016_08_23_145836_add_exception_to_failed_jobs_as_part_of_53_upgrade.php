<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExceptionToFailedJobsAsPartOf53Upgrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('failed_jobs'))
        {
            Schema::table('failed_jobs', function (Blueprint $table)
            {
                /*If your application has a failed_jobs table, you should add an exception column to the table.
                The exception column should be a TEXT type column and will be used to store a string representation of
                the exception that caused the job to fail.
                 */
                $table->text('exception');
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
//        if (Schema::hasTable('failed_jobs'))
//        {
//            Schema::table('failed_jobs', function (Blueprint $table)
//            {
//                $table->dropIfExists('exception');
//            });
//        }
    }
}

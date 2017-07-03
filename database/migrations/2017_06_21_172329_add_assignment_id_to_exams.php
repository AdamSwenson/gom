<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignmentIdToExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function ( Blueprint $table ) {
//            $table->integer('assignment_id')
//                ->unsigned()
//                ->nullable();

//            $table->foreign('assignment_id')
//                ->references('id')
//                ->on('assignments');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
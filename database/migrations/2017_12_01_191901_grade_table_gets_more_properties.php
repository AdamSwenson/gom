<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GradeTableGetsMoreProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function ( Blueprint $table ) {
            $table->text('display_value')->after('id');
            $table->float('calc_value')->after('display_value');
            $table->float('default_cutoff')->after('display_value')->nullable();
            $table->integer('group')->unsigned()->nullable()->after('default_cutoff');
            $table->integer('ordinal')->unsigned()->nullable()->after('group');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

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

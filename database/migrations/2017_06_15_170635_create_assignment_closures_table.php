<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentClosuresTable extends Migration
{
    public function up()
    {
        Schema::create('assignment_closure', function(Blueprint $table)
        {
            $table->increments('closure_id');

            $table->integer('ancestor', false, true);
            $table->integer('descendant', false, true);
            $table->integer('depth', false, true);

            $table->foreign('ancestor')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('descendant')->references('id')->on('assignments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('assignment_closure', function(Blueprint $table)
        {
            Schema::dropIfExists('assignment_closure');
        });
    }
}

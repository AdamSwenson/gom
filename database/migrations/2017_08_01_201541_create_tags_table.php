<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('tags') ) {
            Schema::create('tags', function ( Blueprint $table ) {
                $table->increments('id');
                $table->text('name')->nullable();
                $table->text('text')->nullable();
                $table->json('props')->nullable();
                $table->integer('user_id')->unsigned();
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('tags');

    }
}

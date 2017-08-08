<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('item_tag') ) {
            Schema::create('item_tag', function ( Blueprint $table ) {
                $table->increments('id');
                $table->integer('tag_id')->unsigned();
                $table->integer('item_id')->unsigned();
                $table->timestamps();

                $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('cascade');

                $table->foreign('item_id')
                    ->references('id')
                    ->on('items')
                    ->onDelete('cascade');

                $table->unique(['tag_id', 'item_id']);
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
        Schema::dropIfExists('item_tag');
    }
}

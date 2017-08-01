<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('text')->nullable();
            $table->text('displayText')->nullable();
            $table->text('comment_text')->nullable();
            $table->float('max_score')->nullable();
            $table->json('settings')->nullable();
            $table->integer('exam_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->softDeletes();
$table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');


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
        Schema::dropIfExists('items');

    }
}

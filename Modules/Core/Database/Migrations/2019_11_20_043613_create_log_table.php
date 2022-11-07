<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('action')->nullable();
        $table->string('entity_name')->nullable();
        $table->string('entity_id');
        $table->integer('user_id')->unsigned()->index()->nullable();
        $table->string('ip')->nullable();
        $table->timestamps()->nullable();
        $table->softDeletes()->nullable();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}

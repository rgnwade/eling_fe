<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_formula', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('formula');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('price_formula')->nullable();
            $table->integer('vendor_price_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}

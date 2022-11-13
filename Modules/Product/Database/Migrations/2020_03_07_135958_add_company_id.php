<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //1 = eling
        Schema::table('files', function (Blueprint $table) {
            $table->integer('company_id')->default(1);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('company_id')->default(1);
            $table->decimal('vendor_price', 18, 2)->unsigned();
            $table->integer('minimum_order')->default(1);
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}

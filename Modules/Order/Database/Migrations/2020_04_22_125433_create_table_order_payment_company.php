<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderPaymentCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('order_payment_company', function (Blueprint $table) {
            $table->increments('id');
            $table->date('payment_date')->nullable();
            $table->integer('order_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->decimal('amount', 18, 4)->unsigned();
            $table->string('currency')->nullable();
            $table->string('sender_bank')->nullable();
            $table->string('sender_swift')->nullable();
            $table->string('sender_account')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('beneficiary_bank')->nullable();
            $table->string('beneficiary_swift')->nullable();
            $table->string('beneficiary_account')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('remarks')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
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

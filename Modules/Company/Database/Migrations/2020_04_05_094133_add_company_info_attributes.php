<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyInfoAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('phone', 30);
            $table->string('email', 80);
            $table->string('director_name', 100);
            $table->string('director_passport', 100);
            $table->boolean('fta_status');
            $table->string('fta_number', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('director_name');
            $table->dropColumn('director_passport');
            $table->dropColumn('fta_status');
            $table->dropColumn('fta_number');
        });
    }
}

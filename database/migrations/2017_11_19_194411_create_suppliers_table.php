<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('confirm')->nullable()->default(0);
            // addtional information
            $table->string('title')->nullable();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('company');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('phone');
            $table->string('fax');
            $table->string('website');
            $table->string('company_type');
            $table->string('service_offer');
            $table->rememberToken();
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
        Schema::dropIfExists('suppliers');
    }
}

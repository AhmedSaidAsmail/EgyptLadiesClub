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
            $table->string('password')->nullable();
            $table->boolean('confirm')->nullable()->default(0);
            // addtional information
            $table->string('f_name');
            $table->string('l_name');
            $table->string('mobile');
            $table->string('company');
            $table->string('store_name');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->text('rand_code');
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

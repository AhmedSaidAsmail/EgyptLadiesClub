<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('items_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('en_name');
            $table->string('ar_name');
            $table->string('en_title');
            $table->string('ar_title');
            $table->text('en_description');
            $table->text('ar_description');
            $table->text('en_keywords');
            $table->text('ar_keywords');
            $table->text('en_text');
            $table->text('ar_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('items_details');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('filters_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filter_id')->unsigned();
            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('cascade');
            $table->string('en_name')->unique();
            $table->string('ar_name')->unique();
            $table->integer('sort_order');
            $table->boolean('has_image')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('filters_items');
    }

}

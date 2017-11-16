<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCataegoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->boolean('has_parent')->default(0);
            $table->integer('parent_id')->default(0);
            $table->string('en_name')->unique();
            $table->string('ar_name')->unique();
            $table->integer('arrangement')->default(0);
            $table->string('title');
            $table->text('txt')->nullable();
            $table->string('img')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->integer('recommended')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('categories');
    }

}

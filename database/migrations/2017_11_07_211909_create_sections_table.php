<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('title');
            $table->boolean('status')->default(0);
            $table->boolean('top_list')->default(0);
            $table->integer('arrangement')->default(0);
            $table->text('img')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('language');
            $table->string('currency');
            $table->string('time');
            $table->string('code');
            $table->text('best_time');
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
        Schema::dropIfExists('sections');
    }
}

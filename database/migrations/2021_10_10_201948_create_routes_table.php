<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description');
            $table->float('length')->nullable(false);
            $table->integer('transport');
            $table->integer('language');
            $table->integer('user_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('photo');
            $table->timestamps();
        });

        Schema::table('routes', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}

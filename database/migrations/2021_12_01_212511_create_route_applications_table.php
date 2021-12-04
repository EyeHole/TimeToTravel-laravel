<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->float('length')->nullable(false)->default(0);
            $table->integer('transport')->default(0);
            $table->integer('language')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('photo')->nullable(true);
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('route_applications', function($table) {
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
        Schema::dropIfExists('route_applications');
    }
}

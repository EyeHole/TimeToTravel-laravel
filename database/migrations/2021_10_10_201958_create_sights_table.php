<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sights', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);;
            $table->float('latitude')->nullable(false);
            $table->float('longitude')->nullable(false);
            $table->integer('priority')->default(1);
            $table->integer('route_id')->unsigned();
            $table->json('photos')->nullable(true);
            $table->json('audio')->nullable(true);
            $table->timestamps();
        });

        Schema::table('sights', function($table) {
            $table->foreign('route_id')->references('id')->on('routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sights');
    }
}

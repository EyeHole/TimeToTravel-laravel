<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSightsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sights_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);;
            $table->float('latitude')->nullable(false);
            $table->float('longitude')->nullable(false);
            $table->integer('priority')->default(1);
            $table->integer('route_id')->unsigned();
            $table->json('photos')->nullable(true);
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        
        Schema::table('sights_applications', function($table) {
            $table->foreign('route_id')->references('id')->on('route_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sights_applications');
    }
}

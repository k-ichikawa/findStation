<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('highway_id');
            $table->string('area_name');
            $table->string('area_kana_name');
            $table->double('latitude', 6, 4);
            $table->double('longitude',7, 4);
            $table->unsignedInteger('nearest_station_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('highway_id')->references('id')->on('highway');
            $table->foreign('nearest_station_id')->references('id')->on('nearest_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_info');
    }
}

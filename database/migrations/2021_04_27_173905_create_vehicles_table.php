<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_id');
            $table->string('uid')->nullable();
            $table->string('vin')->unique();
            $table->string('make_and_model')->nullable();
            $table->string('color')->nullable();
            $table->string('transmission')->nullable();
            $table->string('drive_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('car_type')->nullable();
            $table->unsignedTinyInteger('doors')->nullable();
            $table->unsignedBigInteger('mileage')->nullable();
            $table->unsignedBigInteger('kilometrage')->nullable();
            $table->string('license_plate')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}

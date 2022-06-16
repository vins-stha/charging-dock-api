<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //id, name, latitude, longitude, company_id, address
    public function up()
    {
        Schema::create('station', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->double('latitude');
            $table->double('longitude');
            $table->unsignedBigInteger('company_id');

            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
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
        Schema::dropIfExists('station');
    }
}

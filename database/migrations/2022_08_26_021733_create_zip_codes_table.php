<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code');
            $table->string('locality');
            $table->unsignedBigInteger('federal_entity_id');
            $table->unsignedBigInteger('municipality_id');

            $table->foreign('federal_entity_id')->references('id')->on('federal_entities');    
            $table->foreign('municipality_id')->references('id')->on('municipalities');    
        });


        //many to many relations zip_codes with settlements

        Schema::create('settlement_zip_code', function (Blueprint $table) {
            $table->bigIncrements('id');  

            $table->unsignedBigInteger('zip_code_id');
            $table->foreign('zip_code_id')
                  ->references('id')
                  ->on('zip_codes')->onDelete('cascade');

            $table->unsignedBigInteger('settlement_id');
            $table->foreign('settlement_id')
                  ->references('id')
                  ->on('settlements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zip_codes');
    }
};

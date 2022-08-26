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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->integer('key');
            $table->string('name');
            $table->string('zone_type');
            $table->unsignedBigInteger('settlement_type_id');
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->foreign('settlement_type_id')->references('id')->on('settlement_types');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};

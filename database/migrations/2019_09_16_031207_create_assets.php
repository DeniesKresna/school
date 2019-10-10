<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_name');
            $table->string('asset_brand')->nullable();
            $table->string('asset_inventory_code')->nullable();
            $table->string('asset_inventory_numb')->nullable();
            $table->string('asset_serial_numb')->nullable();
            $table->string('asset_description',300)->nullable();
            $table->integer('assettype_id');
            $table->integer('room_id')->nullable();
            $table->integer('asset_created_by');
            $table->integer('asset_updated_by');
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
        Schema::dropIfExists('assets');
    }
}

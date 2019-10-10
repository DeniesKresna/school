<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assettypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assettype_name');
            $table->string('assettype_unit')->nullable();
            $table->integer('group_id');
            $table->integer('assettype_created_by');
            $table->integer('assettype_updated_by');
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
        Schema::dropIfExists('assettypes');
    }
}

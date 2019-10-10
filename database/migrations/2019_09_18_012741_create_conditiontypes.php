<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConditiontypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conditiontypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('conditiontype_name');
            $table->integer('conditiontype_created_by');
            $table->integer('conditiontype_updated_by');
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
        Schema::dropIfExists('conditiontypes');
    }
}

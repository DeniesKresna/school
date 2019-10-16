<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asset_id');
            $table->datetime('receive_at');
            $table->string('receive_sender_identity');
            $table->date('receive_bill_date');
            $table->string('receive_bill_number');
            $table->integer('receiver_id')->nullable();
            $table->integer('receive_created_by');
            $table->integer('receive_updated_by');
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
        Schema::dropIfExists('receives');
    }
}

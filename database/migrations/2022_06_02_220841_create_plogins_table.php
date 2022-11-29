<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePloginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plogins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('practice_id');
            $table->string('loginweb')->nullable();
            $table->string('loginuser')->nullable();
            $table->string('loginpass')->nullable();
            $table->string('additional_information')->nullable();
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
        Schema::dropIfExists('plogins');
    }
}

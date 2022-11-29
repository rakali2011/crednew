<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('practice_id')->references('id')->on('practices');
            $table->string('service_address')->nullable();
            $table->string('service_city')->nullable();
            $table->string('service_county')->nullable();
            $table->string('service_fax')->nullable();
            $table->string('service_phone')->nullable();
            $table->string('service_state')->nullable();
            $table->string('service_zip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plocations');
    }
}

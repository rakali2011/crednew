<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayerProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payer_provider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payer_id');
            $table->integer('provider_id');
            $table->string('provider_identifier');
            $table->string('status');
            $table->date('effective_date')->nullable();
            $table->string('business_line')->nullable();
            $table->date('business_effective_date')->nullable();
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
        Schema::table('payer_provider', function (Blueprint $table) {
            //
        });
    }
}

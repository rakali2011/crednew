<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('practice_name');
            $table->string('practice_code')->nullable();
            $table->string('client_name')->nullable();
            $table->string('group_npi')->nullable();
            $table->string('practice_tax_id')->nullable();
            $table->string('speciality')->nullable();
            $table->string('taxnomy')->nullable();
            $table->string('clia')->nullable();
            $table->string('clia_expiry')->nullable();
            $table->string('service_address')->nullable();
            $table->string('service_city')->nullable();
            $table->string('service_state')->nullable();
            $table->string('service_zip')->nullable();
            $table->string('service_country')->nullable();
            $table->string('service_fax')->nullable();
            $table->string('service_phone')->nullable();
            $table->string('pay_address')->nullable();
            $table->string('pay_city')->nullable();
            $table->string('pay_state')->nullable();
            $table->string('pay_zip')->nullable();
            $table->string('pay_country')->nullable();
            $table->string('contact1_name')->nullable();
            $table->string('contact1_email')->nullable();
            $table->string('contact1_phone')->nullable();
            $table->string('contact1_mobile')->nullable();
            $table->string('contact2_name')->nullable();
            $table->string('contact2_email')->nullable();
            $table->string('contact2_phone')->nullable();
            $table->string('contact2_mobile')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('onwer_email')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_mobile')->nullable();
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('practices');
    }
}

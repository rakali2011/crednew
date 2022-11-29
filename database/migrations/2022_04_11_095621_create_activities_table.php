<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('practice_name')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('payer');
            $table->string('user');
            $table->integer('user_id');
            $table->string('email');
            $table->string('enrollment_credentialing')->nullable();
            $table->string('era_eft_edi_portal')->nullable();
            $table->string('initiated_followup')->nullable();
            $table->string('initiated_date')->nullable();
            $table->string('followup_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('action')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('activities');
    }
}

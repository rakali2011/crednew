<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('individual_npi')->nullable();
            $table->string('full_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('ssn')->nullable();
            $table->string('speciality')->nullable();
            $table->date('provider_signup_date')->nullable();
            $table->string('taxonomy')->nullable();
            $table->string('taxonomy2')->nullable();
            $table->string('home_street')->nullable();
            $table->string('home_suite')->nullable();
            $table->string('home_city')->nullable();
            $table->string('home_state')->nullable();
            $table->string('home_county')->nullable();
            $table->string('home_zip')->nullable();
            $table->string('mailing_street')->nullable();
            $table->string('mailing_suite')->nullable();
            $table->string('mailing_city')->nullable();
            $table->string('mailing_state')->nullable();
            $table->string('mailing_county')->nullable();
            $table->string('mailing_zip')->nullable();
            $table->string('cell')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_county')->nullable();
            $table->string('birth_state')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->string('password')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('medicaid_id')->nullable();
            $table->string('grp_madicaid_id')->nullable();
            $table->string('grp_mrc_id')->nullable();
            $table->string('medicaid_user')->nullable();
            $table->string('medicare_id')->nullable();
            $table->string('website')->nullable();
            $table->string('dea')->nullable();
            $table->string('dea_certification_number')->nullable();
            $table->date('dea_effective_date')->nullable();
            $table->date('dea_expiry_date')->nullable();
            $table->string('state_license')->nullable();
            $table->string('board_certification')->nullable();
            $table->string('board_certification_number')->nullable();
            $table->date('board_effective_date')->nullable();
            $table->date('board_expiry_date')->nullable();
            $table->string('hospital_affiliation')->nullable();
            $table->string('hospital_name')->nullable();
            $table->date('hospital_effective_date')->nullable();
            $table->date('hospital_expiry_date')->nullable();
            $table->string('state_license_option')->nullable();
            $table->string('state_license_number')->nullable();
            $table->date('state_license_date')->nullable();
            $table->date('state_license_expiry')->nullable();
            $table->string('status')->default('active');
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
        Schema::dropIfExists('providers');
    }
}

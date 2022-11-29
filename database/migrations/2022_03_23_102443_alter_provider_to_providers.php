<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProviderToProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->renameColumn('board_certification', 'cds_license_option');
            $table->renameColumn('board_certification_number', 'cds_license_number');
            $table->renameColumn('board_effective_date', 'cds_effective_date');
            $table->renameColumn('board_expiry_date', 'cds_expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->renameColumn('cds_license_option', 'board_certification');
            $table->renameColumn('cds_license_number', 'board_certification_number');
            $table->renameColumn('cds_effective_date', 'board_effective_date');
            $table->renameColumn('cds_expiry_date', 'board_expiry_date');
        });
    }
}

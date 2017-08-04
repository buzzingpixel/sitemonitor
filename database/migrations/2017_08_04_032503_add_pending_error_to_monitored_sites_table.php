<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class AddPendingErrorToMonitoredSitesTable
 */
class AddPendingErrorToMonitoredSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitored_sites', function (Blueprint $table) {
            $table->boolean('pending_error')
                ->default(0)
                ->after('urls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitored_sites', function (Blueprint $table) {
            $table->dropColumn('pending_error');
        });
    }
}

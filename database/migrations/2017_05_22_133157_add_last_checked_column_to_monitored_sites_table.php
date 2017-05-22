<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class AddLastCheckedColumnToMonitoredSitesTable
 */
class AddLastCheckedColumnToMonitoredSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitored_sites', function (Blueprint $table) {
            $table->timestamp('last_checked')
                ->nullable()
                ->after('has_error');
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
            $table->dropColumn('last_checked');
        });
    }
}

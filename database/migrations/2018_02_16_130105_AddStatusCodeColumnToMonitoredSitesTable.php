<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddStatusCodeColumnToMonitoredSitesTable
 */
class AddStatusCodeColumnToMonitoredSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_incidents', function (Blueprint $table) {
            $table->string('status_code')
                ->default('')
                ->after('event_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_incidents', function (Blueprint $table) {
            $table->dropColumn('status_code');
        });
    }
}

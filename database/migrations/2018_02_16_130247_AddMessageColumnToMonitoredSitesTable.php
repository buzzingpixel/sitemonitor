<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddMessageColumnToMonitoredSitesTable
 */
class AddMessageColumnToMonitoredSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_incidents', function (Blueprint $table) {
            $table->text('message')
                ->default('')
                ->after('status_code');
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
            $table->dropColumn('message');
        });
    }
}

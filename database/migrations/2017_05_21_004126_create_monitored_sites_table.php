<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class CreateMonitoredSitesTable
 */
class CreateMonitoredSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitored_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('urls');
            $table->boolean('has_error')->default(0);
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
        Schema::dropIfExists('monitored_sites');
    }
}

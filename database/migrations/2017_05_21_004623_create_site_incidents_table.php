<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class CreateSiteIncidentsTable
 */
class CreateSiteIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('monitored_site_id');
            $table->foreign('monitored_site_id')
                ->references('id')
                ->on('monitored_sites');
            $table->enum('event_type', [
                'down',
                'up'
            ])->default('up');
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
        Schema::dropIfExists('site_incidents');
    }
}

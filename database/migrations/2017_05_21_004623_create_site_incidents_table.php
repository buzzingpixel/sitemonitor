<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            ]);
            $table->dateTime('event_time');
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

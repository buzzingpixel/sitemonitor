<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class AddRemindersTable
 */
class AddRemindersTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('body');
            $table->boolean('is_complete');
            $table->timestamp('start_reminding_on');
            $table->timestamp('last_reminder_sent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}

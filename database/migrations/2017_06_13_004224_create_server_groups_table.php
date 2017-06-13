<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class CreateServerGroupsTable
 */
class CreateServerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->integer('server_group_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_groups');

        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('server_group_id');
        });
    }
}

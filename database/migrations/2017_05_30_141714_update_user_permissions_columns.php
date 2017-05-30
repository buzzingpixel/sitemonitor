<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class UpdateUserPermissionsColumns
 */
class UpdateUserPermissionsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_admin', 'access_sites');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_pings')
                ->default(0)
                ->after('access_sites');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_notifications')
                ->default(0)
                ->after('access_pings');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_admins')
                ->default(0)
                ->after('access_notifications');
        });

        User::query()->where('access_sites', 1)->update([
            'access_pings' => 1,
            'access_notifications' => 1,
            'access_admins' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('access_sites', 'is_admin');
            $table->dropColumn('access_pings');
            $table->dropColumn('access_notifications');
            $table->dropColumn('access_admins');
        });
    }
}

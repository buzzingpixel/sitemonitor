<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

/** @noinspection AutoloadingIssuesInspection */
/**
 * Class AddUserAccessRemindersColumn
 */
class AddUserAccessRemindersColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('access_reminders')
                ->default(0)
                ->after('access_servers');
        });

        User::query()->where('access_admins', 1)->update([
            'access_reminders' => 1
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
            $table->dropColumn('access_reminders');
        });
    }
}

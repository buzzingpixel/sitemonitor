<?php

namespace App\Http\Controllers;

use App\PingGuid;

/**
 * Class PingsCheckinController
 */
class PingsCheckinController extends Controller
{
    /**
     * Ping check in
     * @param PingGuid $ping
     * @return array
     */
    public function checkin(PingGuid $ping)
    {
        // Check the ping in
        $ping->last_ping = time();
        $ping->save();
        return [
            'status' => 'OK'
        ];
    }
}

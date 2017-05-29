<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PingGuid
 */
class PingGuid extends Ping
{
    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'guid';
    }
}

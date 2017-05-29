<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ping
 *
 * @property int $id Primary key
 * @property string $guid
 * @property string $name
 * @property int $expect_every
 * @property int $warn_after
 * @property int $last_ping
 * @property bool $has_error
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class Ping extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'pings';
}

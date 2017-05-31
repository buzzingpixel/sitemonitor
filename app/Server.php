<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 * @property int $id Primary key
 * @property string $name
 * @property string $address
 * @property int $port
 * @property string $username
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class Server extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'servers';
}

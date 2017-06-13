<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ServerGroup
 * @property int $id Primary key
 * @property string $name
 * @property Collection $servers
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class ServerGroup extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'server_groups';

    /**
     * The values that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Servers
     */
    public function servers()
    {
        return $this->hasMany(Server::class);
    }
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SshKey
 * @property int $id Primary key
 * @property int $user_id ID of the user this key belongs to
 * @property User $user
 * @property string $name Key name
 * @property string $key The key
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class SshKey extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'ssh_keys';

    /**
     * Get the user that owns the ssh key
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

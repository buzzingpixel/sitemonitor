<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SshServerUserKey
 * @property int $id Primary key
 * @property int $user_id
 * @property User $user
 * @property int $ssh_key_id
 * @property SshKey $sshKey
 * @property int $server_id
 * @property Server $server
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class SshServerUserKey extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'ssh_server_user_keys';

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the SshKey
     */
    public function sshKey()
    {
        return $this->belongsTo(SshKey::class);
    }

    /**
     * Get the Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Server
 * @property int $id Primary key
 * @property string $name
 * @property string $address
 * @property int $port
 * @property string $username
 * @property Collection $sshServerUserKeys
 * @property ServerGroup $serverGroup
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

    /**
     * The values that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'port',
        'username',
    ];

    /**
     * Inputs
     * @var array
     */
    public static $inputs = [
        [
            'view' => 'formPartials.text',
            'name' => 'name',
            'type' => 'text',
            'title' => 'Name',
            'placeholder' => 'my-server-name',
            'required' => true
        ],
        [
            'view' => 'formPartials.text',
            'name' => 'address',
            'type' => 'text',
            'title' => 'Address or IP',
            'placeholder' => '192.168.0.0.1',
            'required' => true
        ],
        [
            'view' => 'formPartials.text',
            'name' => 'port',
            'type' => 'text',
            'title' => 'SSH Port',
            'placeholder' => '22',
            'value' => '22',
            'required' => true
        ],
        [
            'view' => 'formPartials.text',
            'name' => 'username',
            'type' => 'text',
            'title' => 'SSH Username',
            'placeholder' => 'forge',
            'required' => true
        ]
    ];

    /**
     * SSH Server Keys
     */
    public function sshServerUserKeys()
    {
        return $this->hasMany(SshServerUserKey::class)
            ->where('user_id', \Auth::getUser()->id);
    }

    /**
     * ServerGroup
     */
    public function serverGroup()
    {
        return $this->belongsTo(ServerGroup::class);
    }
}

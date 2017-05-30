<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class User
 * @property int $id Primary key
 * @property string $name User name
 * @property string $email User emails
 * @property bool $access_sites Whether user can access sites admin
 * @property bool $access_pings Whether user can access pings admin
 * @property bool $access_notifications Whether user can access notifications admin
 * @property bool $access_admins Whether user can access admins admin
 * @property Collection $sshKeys
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get sshKeys
     */
    public function sshKeys()
    {
        return $this->hasMany(SshKey::class)
            ->orderBy('created_at', 'desc');
    }
}

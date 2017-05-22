<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationEmail
 *
 * @property int $id Primary key
 * @property string $email Email address
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class NotificationEmail extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'notification_emails';
}

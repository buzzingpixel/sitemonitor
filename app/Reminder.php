<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reminder
 * @property-read int $id
 * @property string $name
 * @property string $body
 * @property boolean $is_complete
 * @property Carbon $start_reminding_on
 * @property Carbon $last_reminder_sent
 * @property-read Carbon $created_at When the record was created
 * @property-read Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class Reminder extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'reminders';
}

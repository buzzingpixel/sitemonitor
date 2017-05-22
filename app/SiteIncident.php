<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SiteIncident
 *
 * @property int $id Primary key
 * @property int $monitored_site_id ID of the monitored site
 * @property string $event_type down|up
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class SiteIncident extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'site_incidents';
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\SiteIncident;

/**
 * Class MonitoredSite
 *
 * @property int $id Primary key
 * @property string $name Site name
 * @property string $urls The urls to check for this site
 * @property bool $has_error Whether the site has an error as of last check
 * @property Collection $incidents
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class MonitoredSite extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'monitored_sites';

    /**
     * Get incidents
     */
    public function incidents()
    {
        return $this->hasMany(SiteIncident::class)->orderBy('created_at', 'desc')->limit(50);
    }
}

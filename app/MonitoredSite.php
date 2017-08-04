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
 * @property bool $pending_error Whether site has pending error
 * @property bool $has_error Whether site has error
 * @property Collection $incidents
 * @property Carbon $last_checked When the site was last checked for up or down
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

    /**
     * Get URLs as array
     * @return array
     */
    public function getUrlsAsArray()
    {
        return array_map(function ($i) {
            return trim($i);
        }, explode(',', $this->urls));
    }

    /**
     * @param $val
     * @return Carbon|null
     */
    public function getLastCheckedAttribute($val)
    {
        if (! $val) {
            return null;
        }

        return new Carbon($val);
    }
}

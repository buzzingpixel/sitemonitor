<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ping
 *
 * @property int $id Primary key
 * @property string $guid
 * @property string $name
 * @property int $expect_every
 * @property int $warn_after
 * @property int $last_ping
 * @property bool $has_error
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @mixin \Eloquent
 */
class Ping extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'pings';

    /**
     * Save the model to the database
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []) : bool
    {
        // If this is a new record, we have some work to do
        if (! $this->exists) {
            $this->prepareNewSave();
        }

        // Run parent save method
        return parent::save($options);
    }

    /**
     * Get health status
     * @return string
     */
    public function getHealthStatus() : string
    {
        $time = time();
        $expectTime = $this->last_ping + $this->expect_every;
        $warnTime = $expectTime + $this->warn_after;

        if ($time > $warnTime) {
            return 'pastWarning';
        }

        if ($time > $expectTime) {
            return 'pastExpect';
        }

        return 'healthy';
    }

    /**
     * Set timestamp from minutes
     * @param string $param
     * @param int $minutes
     */
    public function setMinutes($param, $minutes)
    {
        $this->{$param} = $minutes * 60;
    }

    /**
     * Get minutes from seconds
     */
    public function getMinutes($param)
    {
        return $this->{$param} / 60;
    }

    /**
     * Get timestamp as Carbon
     * @param string $param
     * @return Carbon
     */
    public function asCarbon($param) : Carbon
    {
        return Carbon::createFromTimestamp($this->{$param}, new \DateTimeZone('UTC'));
    }

    /**
     * Prepare new save
     */
    private function prepareNewSave()
    {
        $this->guid = $this->generateGuid();
        $this->last_ping = time();
    }

    /*
     *  References
     *      - http://www.php.net/manual/en/function.com-create-guid.php
     *      - http://guid.us/GUID/PHP
     */
    /**
     * Generate GUID
     * @param bool $prefix
     * @param bool $braces
     * @return string
     * References
     *     - http://www.php.net/manual/en/function.com-create-guid.php
     *     - http://guid.us/GUID/PHP
     */
    public function generateGuid($prefix = false, $braces = false) : string
    {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid($prefix === false ? rand() : $prefix, true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        // Add brackets or not? "{" ... "}"
        return $braces ? chr(123) . $uuid . chr(125) : $uuid;
    }

    /**
     * Get ping URL
     * @return string
     */
    public function getPingUrl() : string
    {
        return url("/pings/checkin/{$this->guid}");
    }
}

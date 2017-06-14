<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ScriptSet
 * @property int $id Primary key
 * @property string $name
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @property Collection $scripts
 * @mixin \Eloquent
 */
class ScriptSet extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'script_sets';

    /**
     * Servers
     */
    public function scripts()
    {
        return $this->hasMany(Script::class)->orderBy('position', 'asc');
    }
}

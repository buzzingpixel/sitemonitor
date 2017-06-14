<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Script
 * @property int $id Primary key
 * @property int $script_set_id
 * @property int $position
 * @property string $name
 * @property string $content
 * @property Carbon $created_at When the record was created
 * @property Carbon updated_at When the record was updated
 * @property ScriptSet $scriptSet
 * @mixin \Eloquent
 */
class Script extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'scripts';

    /**
     * ScriptSet
     */
    public function scriptSet()
    {
        return $this->belongsTo(ScriptSet::class);
    }
}

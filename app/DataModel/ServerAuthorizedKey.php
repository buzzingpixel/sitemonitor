<?php

namespace App\DataModel;

use BuzzingPixel\DataModel\Model;
use BuzzingPixel\DataModel\DataType;

/**
 * Class ServerAuthorizedKey
 * @property string $key
 */
class ServerAuthorizedKey extends Model
{
    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * Define attributes
     * @return array
     */
    public function defineAttributes() : array
    {
        return array(
            'key' => DataType::STRING
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Log the fields in activity model
     *
     * @var string[]
     */
    protected static $logAttributes = ['*'];

    /**
     * Log only changed attributes
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * Ignore field
     *
     * @var string[]
     */
    protected static $ignoreChangedAttributes = ['updated_at'];
}

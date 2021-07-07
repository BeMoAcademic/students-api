<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlobalPopup extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'active', 'title'
    ];

    protected $casts = [
        'plans' => 'array',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}

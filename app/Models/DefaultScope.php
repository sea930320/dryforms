<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultScope extends Model
{
    /**
     * @var string
     */
    public $table = 'default_scopes';

    /**
     * @var array
     */
    public $fillable = [
        'selected',
        'service',
        'units',
        'is_header'
    ];
    /**
     * @var array
     */
    public $visible = [
        'selected',
        'service',
        'units',
        'is_header'
    ];
}

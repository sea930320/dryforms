<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultArea extends Model
{
    /**
     * @var string
     */
    public $table = 'default_areas';

    /**
     * @var array
     */
    public $fillable = [
        'title'
    ];
    /**
     * @var array
     */
    public $visible = [
        'id', 
        'title'
    ];
}

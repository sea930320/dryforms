<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultFromData extends Model
{
    /**
     * @var string
     */
    public $table = 'default_forms_data';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'title',
        'statement'
    ];

    /**
     * @var array
     */
    public $visible = [
        'name',
        'title',
        'statement'
    ];
}
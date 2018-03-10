<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    /**
     * @var string
     */
    public $table = 'project_status';

    /**
     * @var array
     */
    public $fillable = [
        'name'
    ];

    /**
     * @var array
     */
    public $visible = [
    	'id',
        'name'
    ];
}

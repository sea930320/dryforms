<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultTeam extends Model
{
    /**
     * @var string
     */
    public $table = 'default_teams';

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
        'id', 'name'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultStructure extends Model
{
        /**
     * @var string
     */
    public $table = 'default_structures';

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
        'id', 'title'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultMaterial extends Model
{
        /**
     * @var string
     */
    public $table = 'default_materials';

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
        'title'
    ];
}

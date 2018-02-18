<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardMaterial extends Model
{
    /**
     * @var string
     */
    public $table = 'standard_materials';

    /**
     * @var array
     */
    public $fillable = ['title', 'type', 'company_id'];

    /**
     * @var array
     */
    public $visible = [
        'id',
        'title',
        'type',
        'company_id'
    ];
}

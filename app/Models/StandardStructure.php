<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardStructure extends Model
{
    /**
     * @var string
     */
    public $table = 'standard_structures';

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

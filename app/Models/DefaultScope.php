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
        'is_header',
        'qty',
        'uom',
        'page',
        'no'
    ];
    /**
     * @var array
     */
    public $visible = [
        'selected',
        'service',
        'is_header',
        'qty',
        'uom',
        'page',
        'no'
    ];

    /**
     * Relation with unit_of_measure.
     */
    public function uom_info()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'uom');
    }
}

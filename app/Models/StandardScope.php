<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class StandardScope extends Model
{
    use BelongsToCompany;
    /**
     * @var string
     */
    public $table = 'standard_scopes';

    /**
     * @var array
     */
    public $fillable = [
        'company_id',
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
        'id',
        'company_id',
        'selected',
        'service',
        'is_header',
        'qty',
        'page',
        'uom',
        'no',

        'uom_info'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation with unit_of_measure.
     */
    public function uom_info()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'uom');
    }
}

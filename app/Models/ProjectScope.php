<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCompany;

class ProjectScope extends Model
{
    use BelongsToCompany;
    /**
     * @var string
     */
    public $table = 'project_scopes';

    /**
     * @var array
     */
    public $fillable = [
    	'project_id',
        'company_id',
        'project_area_id',
        'standard_scope_edited',
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
        'project_id',
        'company_id',
        'project_area_id',
        'standard_scope_edited',
        'selected',
        'service',
        'is_header',
        'qty',
        'uom',
        'page',
        'no',

        'uom_info',
        'project',
        'project_area',
        'standard_scope'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project_area()
    {
        return $this->belongsTo(ProjectArea::class, 'project_area_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function standard_scope()
    {
        return $this->belongsTo(StandardScope::class, 'standard_scope_id');
    }

    /**
     * Relation with unit_of_measure.
     */
    public function uom_info()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'uom');
    }
}

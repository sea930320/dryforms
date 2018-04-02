<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCompany;

class ProjectArea extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'project_areas';

    /**
     * @var array
     */
    public $fillable = [
    	'project_id',
        'company_id',
        'area_id'
    ];

    /**
     * @var array
     */
    public $visible = [
        'id',
        'project_id',
        'company_id',
        'area_id',

        'company',
        'project',
        'standard_area'
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
    public function standard_area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}

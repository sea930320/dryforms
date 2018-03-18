<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ProjectDailylog extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'project_dailylogs';

    /**
     * @var array
     */
    public $fillable = [    	
        'company_id',
        'form_id',
        'project_id',
        'is_copied',
        'notes'
    ];

    /**
     * @var array
     */
    public $visible = [
    	'id',
        'company_id',
        'form_id',
        'project_id',
        'is_copied',
        'notes',
        'updated_at',

        'company',
        'default_form_data',
        'standard_form',
        'project'
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
    public function default_form_data()
    {
        return $this->hasOne(DefaultFromData::class, 'form_id', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function standard_form()
    {
        return $this->hasOne(DefaultFromData::class, 'form_id', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ProjectForm extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'project_forms';

    /**
     * @var array
     */
    public $fillable = [
    	'form_id',
        'company_id',
        'project_id',
        'insured_signature',
        'company_signature',
        'insured_signature_upated_at',
        'company_signature_upated_at'
    ];

    /**
     * @var array
     */
    public $visible = [
        'company_id',
        'form_id',
        'project_id',
        'insured_signature',
        'company_signature',
        'insured_signature_upated_at',
        'company_signature_upated_at',
        'updated_at',

        'company',
        'default_form_data',
        'standard_form',
        'project'
    ];

    /**
     * @var array
     */
    public $with = [
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

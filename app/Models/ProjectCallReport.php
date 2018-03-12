<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ProjectCallReport extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'project_call_reports';

    /**
     * @var array
     */
    public $fillable = [
        'company_id',
        'project_id',
        'contact_name',
        'contact_phone',
        'site_phone',
        'date_contacted',
        'time_contacted',
        'date_loss',
        'point_loss',
        'date_completed',
        'category',
        'class',
        'job_address',
        'city',
        'state',
        'zip_code',
        'cross_streets',
        'apartment_name',
        'building_no',
        'apartment_no',
        'gate_code',
        'assigned_to',
        'is_residential',
        'is_commercial',
        'is_insured',
        'is_tenant',
        'is_water',
        'is_sewage',
        'is_mold',
        'is_fire',
        'insured_name',
        'billing_address',
        'insured_city',
        'insured_state',
        'insured_zip_code',
        'insured_home_phone',
        'insured_cell_phone',
        'insured_work_phone',
        'insured_email',
        'insured_fax',
        'insurance_claim_no',
        'insurance_company',
        'insurance_policy_no',
        'insurance_deductible',
        'insurance_adjuster',
        'insurance_address',
        'insurance_city',
        'insurance_state',
        'insurance_zip_code',
        'insurance_work_phone',
        'insurance_cell_phone',
        'insurance_email',
        'insurance_fax'
    ];

    /**
     * @var array
     */
    public $visible = [
        'id',
        'company_id',
        'project_id',
        'contact_name',
        'contact_phone',
        'site_phone',
        'date_contacted',
        'time_contacted',
        'date_loss',
        'point_loss',
        'date_completed',
        'category',
        'class',
        'job_address',
        'city',
        'state',
        'zip_code',
        'cross_streets',
        'apartment_name',
        'building_no',
        'apartment_no',
        'gate_code',
        'assigned_to',
        'is_residential',
        'is_commercial',
        'is_insured',
        'is_tenant',
        'is_water',
        'is_sewage',
        'is_mold',
        'is_fire',
        'insured_name',
        'billing_address',
        'insured_city',
        'insured_state',
        'insured_zip_code',
        'insured_home_phone',
        'insured_cell_phone',
        'insured_work_phone',
        'insured_email',
        'insured_fax',
        'insurance_claim_no',
        'insurance_company',
        'insurance_policy_no',
        'insurance_deductible',
        'insurance_adjuster',
        'insurance_address',
        'insurance_city',
        'insurance_state',
        'insurance_zip_code',
        'insurance_work_phone',
        'insurance_cell_phone',
        'insurance_email',
        'insurance_fax',

        'company',
        'project',
        'assignee'
    ];

    /**
     * @var array
     */
    public $with = [
        'company',
        'project',
        'assignee'
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
    public function assignee()
    {
        return $this->belongsTo(Team::class, 'assigned_to');
    }
}

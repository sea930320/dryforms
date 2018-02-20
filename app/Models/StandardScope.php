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
        'units',
        'is_header'
    ];

	/**
     * @var array
     */
    public $visible = [
        'company_id',
        'selected',
        'service',
        'units',
        'is_header'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

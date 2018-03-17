<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class StandardDailylogSetting extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'standard_dailylog_settings';

    /**
     * @var array
     */
    public $fillable = [
    	'id',
    	'company_id',
    	'automatically_copy',

    	'company'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

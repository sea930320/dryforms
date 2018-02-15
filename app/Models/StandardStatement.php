<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class StandardStatement extends Model
{
    use BelongsToCompany;
    /**
     * @var string
     */
    public $table = 'standard_statements';

    /**
     * @var array
     */
    public $fillable = [
    	'company_id',
        'form_id',
        'title',
        'statement',        
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
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}

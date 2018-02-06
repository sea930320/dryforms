<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class StandardForm extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'standard_forms';

    /**
     * @var array
     */
    public $fillable = [
        'form_id',
        'name',
        'title',
        'statement',
        'company_id'
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
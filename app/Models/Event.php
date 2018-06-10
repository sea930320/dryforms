<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * @var array
     */
    protected $fillable = [
        'company_id', 'title', 'start', 'end', 'color'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id',
        'company_id',
        'title',
        'start',
        'end',
        'color'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

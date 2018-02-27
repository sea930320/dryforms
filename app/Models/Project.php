<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    public $table = 'projects';

    /**
     * @var array
     */
    public $fillable = [
        'company_id',
        'owner_id',
        'assigned_to',
        'address',
        'phone',
        'status'
    ];

    /**
     * @var array
     */
    public $visible = [
        'company_id',
        'owner_id',
        'assigned_to',
        'address',
        'phone',
        'status',

        'company',
        'owner',
        'assignee'
    ];

    /**
     * @var array
     */
    public $with = [
        'company',
        'owner',
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
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
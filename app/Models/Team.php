<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_id'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'company_id',

        'company'
    ];

    /**
     * Relation with equipments.
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
